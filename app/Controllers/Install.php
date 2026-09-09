<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Config\Database;

/**
 * Web Installation Wizard
 * UI based on jmrashed/php-installer (recolored to AdminLTE skin-blue).
 *
 * Steps: welcome -> system_check -> db_config -> db_import -> app_config -> finish
 * After completion a lock file (writable/installer.lock) prevents re-installation.
 */
class Install extends Controller
{
    protected $steps = [
        'welcome',
        'license',
        'system_check',
        'db_config',
        'db_import',
        'app_config',
        'finish',
    ];

    protected $lockFile = WRITEPATH . 'installer.lock';

    public function __construct()
    {
        // Must resolve the session service so the session is actually STARTED.
        // Without this, $_SESSION writes/reads are not persisted between requests
        // (CI4 does not auto-start sessions; other controllers call Services::session()).
        session();
    }

    public function index()
    {
        if (is_file($this->lockFile)) {
            http_response_code(403);
            return '<h1>Already Installed</h1><p>This application has already been installed. Delete <code>writable/installer.lock</code> if you need to run the installer again.</p>';
        }

        $step = $this->currentStep();
        $data = [];

        switch ($step) {
            case 'system_check':
                $data['requirements'] = $this->checkRequirements();
                $all = array_merge([$data['requirements']['php_version']], $data['requirements']['extensions'], $data['requirements']['writable_directories']);
                $data['errors'] = array_filter($all, function ($r) { return !$r['status']; });
                break;

            case 'db_config':
                $data['db_driver']   = $_SESSION['db_driver']   ?? 'mysql';
                $data['db_host']     = $_SESSION['db_host']     ?? 'localhost';
                $data['db_name']     = $_SESSION['db_name']     ?? '';
                $data['db_username'] = $_SESSION['db_username'] ?? 'root';
                $data['db_password'] = $_SESSION['db_password'] ?? '';
                break;

            case 'app_config':
                $protocol   = $this->request->isSecure() ? 'https' : 'http';
                $host       = $this->request->getServer('HTTP_HOST') ?? 'localhost';
                // Default app name = the project folder name (e.g. "C4")
                $appFolder  = basename(ROOTPATH);
                // Default app URL = full auto-detected URL including subfolder + /login
                $defaultUrl = $protocol . '://' . $host . '/' . $appFolder . '/login';
                $data['app_name'] = $_SESSION['app_name'] ?? $appFolder;
                $data['app_url']  = $_SESSION['app_url']  ?? $defaultUrl;
                break;

        }

        return $this->render($step, $data);
    }

    public function submit()
    {
        if (is_file($this->lockFile)) {
            return redirect()->to(base_url('login'));
        }

        $step = $this->currentStep();

        switch ($step) {
            case 'welcome':
                $this->nextStep();
                break;

            case 'license':
                $this->nextStep();
                break;

            case 'system_check':
                $req = $this->checkRequirements();
                $all = array_merge([$req['php_version']], $req['extensions'], $req['writable_directories']);
                $failed = array_filter($all, function ($r) { return !$r['status']; });
                if (!empty($failed)) {
                    session()->setFlashdata('alerts', [['type' => 'danger', 'message' => 'System requirements not met. Please fix the highlighted items.']]);
                    return redirect()->to(base_url('install?step=system_check'));
                }
                $this->nextStep();
                break;

            case 'db_config':
                foreach (['db_driver', 'db_host', 'db_port', 'db_name', 'db_username', 'db_password'] as $k) {
                    $_SESSION[$k] = $this->request->getPost($k);
                }
                if (trim((string) ($_SESSION['db_name'] ?? '')) === '') {
                    session()->setFlashdata('alerts', [['type' => 'danger', 'message' => 'Please enter a database name.']]);
                    return redirect()->to(base_url('install?step=db_config'));
                }
                $test = $this->testConnection($_SESSION['db_driver'], $_SESSION['db_host'], $_SESSION['db_port'], $_SESSION['db_name'], $_SESSION['db_username'], $_SESSION['db_password']);
                if ($test !== true) {
                    session()->setFlashdata('alerts', [['type' => 'danger', 'message' => 'Database connection failed: ' . $test]]);
                    return redirect()->to(base_url('install?step=db_config'));
                }
                $this->nextStep();
                break;

            case 'db_import':
                // Guard: database configuration must exist in the session before importing
                if (trim((string) ($_SESSION['db_name'] ?? '')) === '') {
                    session()->setFlashdata('alerts', [['type' => 'warning', 'message' => 'Please complete the Database Configuration step first.']]);
                    return redirect()->to(base_url('install?step=db_config'));
                }
                $err = $this->importDatabase();
                if ($err !== true) {
                    session()->setFlashdata('alerts', [['type' => 'danger', 'message' => $err]]);
                    return redirect()->to(base_url('install?step=db_import'));
                }
                $this->nextStep();
                break;

            case 'app_config':
                $_SESSION['app_name'] = $this->request->getPost('app_name');
                $_SESSION['app_url']  = $this->request->getPost('app_url');
                $this->writeAppConfig($_SESSION['app_name']);
                $this->nextStep();
                break;

            case 'finish':
                file_put_contents($this->lockFile, time());
                session()->destroy();
                return redirect()->to(base_url('login'));

            default:
                return redirect()->to(base_url('install'));
        }

        return redirect()->to(base_url('install?step=' . ($_SESSION['installer_step'] ?? 'welcome')));
    }

    /* ---------------- internals ---------------- */

    private function currentStep()
    {
        $step = $this->request->getGet('step');
        if ($step && in_array($step, $this->steps)) {
            $_SESSION['installer_step'] = $step;
            return $step;
        }
        return $_SESSION['installer_step'] ?? 'welcome';
    }

    private function nextStep()
    {
        $idx = array_search($this->currentStep(), $this->steps);
        if ($idx !== false && $idx < count($this->steps) - 1) {
            $_SESSION['installer_step'] = $this->steps[$idx + 1];
        }
    }

    private function render($step, $data = [])
    {
        $alerts = session()->getFlashdata('alerts') ?: [];
        extract($data, EXTR_SKIP);

        $steps            = $this->steps;
        $totalSteps       = count($this->steps);
        $currentStep      = $step;
        $currentStepIndex = array_search($step, $this->steps);
        $installer        = $this;

        echo view('install/layouts/header');
        include APPPATH . 'Views/install/steps/' . $step . '.php';
        echo view('install/layouts/footer');
        return '';
    }

    private function checkRequirements()
    {
        $dirs = [
            WRITEPATH,
            APPPATH . 'Config',
            ROOTPATH . 'public/dist/img/uploads',
        ];

        return [
            'php_version' => [
                'name'     => 'PHP Version',
                'required' => '7.4+',
                'current'  => PHP_VERSION,
                'status'   => version_compare(PHP_VERSION, '7.4.0', '>='),
                'message'  => version_compare(PHP_VERSION, '7.4.0', '>=') ? 'OK' : 'Too old',
            ],
            'extensions' => array_map(function ($ext) {
                $ok = extension_loaded($ext);
                return ['name' => $ext, 'status' => $ok, 'message' => $ok ? 'Loaded' : 'Missing'];
            }, ['mysqli', 'pdo', 'json', 'mbstring', 'session', 'fileinfo', 'curl']),
            'writable_directories' => array_map(function ($dir) {
                $ok = is_writable($dir);
                return ['name' => $dir, 'status' => $ok, 'message' => $ok ? 'Writable' : 'Not writable'];
            }, $dirs),
        ];
    }

    private function testConnection($driver, $host, $port, $dbname, $user, $pass)
    {
        try {
            if ($driver === 'mysql') {
                $dsn = "mysql:host={$host};port={$port}";
                $pdo = new \PDO($dsn, $user, $pass, [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
                $pdo->exec("CREATE DATABASE IF NOT EXISTS `" . str_replace('`', '', $dbname) . "` CHARACTER SET utf8 COLLATE utf8_general_ci");
            } elseif ($driver === 'pgsql') {
                $dsn = "pgsql:host={$host};port={$port}";
                $pdo = new \PDO($dsn, $user, $pass, [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
                $stmt = $pdo->query("SELECT 1 FROM pg_database WHERE datname = " . $pdo->quote($dbname));
                if ($stmt->fetch() === false) {
                    $pdo->exec('CREATE DATABASE "' . str_replace('"', '', $dbname) . '"');
                }
            } else { // sqlite
                new \PDO('sqlite:' . $dbname);
            }
            return true;
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }

    private function importDatabase()
    {
        $driver = $_SESSION['db_driver'] ?? 'mysql';
        $host   = $_SESSION['db_host'] ?? 'localhost';
        $port   = $_SESSION['db_port'] ?? '3306';
        $dbname = $_SESSION['db_name'] ?? '';
        $user   = $_SESSION['db_username'] ?? 'root';
        $pass   = $_SESSION['db_password'] ?? '';

        // Resolve SQL source: uploaded file or default database/install.sql
        $file = $this->request->getFile('sql_file');
        if ($file && $file->isValid()) {
            $tmp = $file->getTempName();
            if (strtolower($file->getClientExtension()) === 'zip' || $file->getClientMimeType() === 'application/zip') {
                $zip = new \ZipArchive();
                if ($zip->open($tmp) !== true) {
                    return 'Failed to open ZIP file.';
                }
                $extractPath = sys_get_temp_dir() . '/installer_' . uniqid();
                mkdir($extractPath, 0755, true);
                $zip->extractTo($extractPath);
                $zip->close();
                $found = false;
                $it = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($extractPath));
                foreach ($it as $f) {
                    if ($f->isFile() && strtolower($f->getExtension()) === 'sql') { $found = $f->getPathname(); break; }
                }
                if (!$found) { return 'No .sql file found in ZIP archive.'; }
                $tmp = $found;
            }
        } else {
            $tmp = ROOTPATH . 'database' . DIRECTORY_SEPARATOR . 'install.sql';
            if (!is_file($tmp)) {
                return 'No SQL file uploaded and no default schema found at database/install.sql.';
            }
        }

        $sql = file_get_contents($tmp);

        try {
            if ($driver === 'mysql') {
                // Connect without dbname (avoids DSN parsing issues / 'No database selected'),
                // ensure the database exists, then select it explicitly.
                $pdo = new \PDO("mysql:host={$host};port={$port}", $user, $pass, [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                ]);
                if (trim((string) $dbname) === '') {
                    return 'No database name was provided. Please go back to Database Configuration and enter a database name.';
                }
                $pdo->exec("CREATE DATABASE IF NOT EXISTS `" . str_replace('`', '', $dbname) . "` CHARACTER SET utf8 COLLATE utf8_general_ci");
                $pdo->exec("USE `" . str_replace('`', '', $dbname) . "`");
            } elseif ($driver === 'pgsql') {
                $pdo = new \PDO("pgsql:host={$host};port={$port};dbname={$dbname}", $user, $pass, [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
            } else {
                $pdo = new \PDO('sqlite:' . $dbname, null, null, [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
            }
            // Execute statement-by-statement (avoids 'Got a packet bigger than
            // max_allowed_packet' on large dumps and reports per-statement errors).
            // Tolerates re-imports: "table already exists" / "duplicate column"
            // / "database exists" errors from a previous partial run are skipped.
            $imported = 0;
            $lastError = null;
            foreach ($this->splitSql($sql) as $stmt) {
                if (trim($stmt) === '') {
                    continue;
                }
                try {
                    $pdo->exec($stmt);
                    $imported++;
                } catch (\PDOException $pe) {
                    $code = $pe->getCode();
                    $msg  = $pe->getMessage();
                    $benign = ($code === '42S01')                      // table already exists
                           || ($code === '42S21')                      // duplicate column
                           || ($code === '42S02' && stripos($msg, 'DROP') !== false && stripos($stmt, 'DROP') === 0)
                           || (strpos($code, '10') === 0 && (stripos($msg, 'already exists') !== false || stripos($msg, 'duplicate') !== false));
                    if ($benign) {
                        $imported++;
                        continue;
                    }
                    throw $pe;
                }
            }
            if ($imported === 0 && $lastError === null && trim($sql) === '') {
                return 'The SQL file appears to be empty.';
            }
        } catch (\Throwable $e) {
            return 'Import failed: ' . $e->getMessage();
        }

        // Persist connection details to .env (uncomment + set)
        $this->writeEnvDb($driver, $host, $port, $dbname, $user, $pass);
        return true;
    }

    /**
     * Split a raw SQL dump into individual statements.
     * - Strips comment-only lines (-- and #)
     * - Respects semicolons inside single/double-quoted strings
     * - Handles DELIMITER switches (routines/triggers)
     */
    private function splitSql($sql)
    {
        $statements = [];
        $buffer = '';
        $delimiter = ';';
        $inString = null;

        foreach (preg_split('/\R/', $sql) as $line) {
            $t = ltrim($line);
            if ($t === '' || strpos($t, '--') === 0 || strpos($t, '#') === 0) {
                continue; // skip comment-only / blank lines
            }

            // DELIMITER switch line (outside any string)
            if ($inString === null && preg_match('/^\s*DELIMITER\s+(\S+)\s*$/i', $line, $m)) {
                if (trim($buffer) !== '') {
                    $statements[] = $buffer;
                    $buffer = '';
                }
                $delimiter = $m[1];
                continue;
            }

            $buffer .= $line . "\n";

            // Scan the line for string state and delimiter at end (outside string)
            $n = strlen($line);
            for ($i = 0; $i < $n; $i++) {
                $ch = $line[$i];
                if ($inString !== null) {
                    if ($ch === '\\') { $i++; continue; } // escaped char
                    if ($ch === $inString) { $inString = null; }
                    continue;
                }
                if ($ch === "'" || $ch === '"') {
                    $inString = $ch;
                }
            }

            // Statement complete when line ends with the current delimiter (outside a string)
            if ($inString === null && strlen($t) >= strlen($delimiter)
                && substr(rtrim($t, " \t\r\n"), -strlen($delimiter)) === $delimiter) {
                $statements[] = $buffer;
                $buffer = '';
            }
        }
        if (trim($buffer) !== '') {
            $statements[] = $buffer;
        }

        // Strip trailing delimiters from each statement
        return array_values(array_filter(array_map(function ($s) use ($delimiter) {
            $s = trim($s);
            if ($s !== '' && substr($s, -strlen($delimiter)) === $delimiter) {
                $s = rtrim(substr($s, 0, -strlen($delimiter)));
            }
            return $s;
        }, $statements), function ($s) { return $s !== ''; }));
    }

    private function writeEnvDb($driver, $host, $port, $dbname, $user, $pass)
    {
        $envPath = ROOTPATH . '.env';
        if (!is_file($envPath) || !is_writable($envPath)) {
            return;
        }
        $lines = file($envPath, FILE_IGNORE_NEW_LINES);
        $map = [
            'database.default.hostname' => $host,
            'database.default.database' => $dbname,
            'database.default.username' => $user,
            'database.default.password' => $pass,
            'database.default.port'     => $port,
            'database.default.DBDriver' => $driver === 'mysql' ? 'MySQLi' : ($driver === 'pgsql' ? 'Postgre' : 'SQLite3'),
        ];
        $written = [];
        foreach ($lines as $i => $line) {
            foreach ($map as $key => $val) {
                if (!in_array($key, $written) && preg_match('/^#?\s*' . preg_quote($key, '/') . '\s*=/', $line)) {
                    $lines[$i] = $key . ' = ' . $val;
                    $written[] = $key;
                    continue 2;
                }
            }
        }
        foreach ($map as $key => $val) {
            if (!in_array($key, $written)) {
                $lines[] = $key . ' = ' . $val;
            }
        }
        file_put_contents($envPath, implode("\n", $lines));
    }

    private function writeAppConfig($appName)
    {
        // Store the chosen app name in a simple writable config for the app to read.
        $file = WRITEPATH . 'installed_app_name.php';
        file_put_contents($file, "<?php return " . var_export(['app_name' => $appName], true) . ";");
    }
}
