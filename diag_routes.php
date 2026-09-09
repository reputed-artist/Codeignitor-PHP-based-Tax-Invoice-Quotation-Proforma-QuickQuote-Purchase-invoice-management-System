<?php
/**
 * Temporary diagnostic - do NOT commit.
 * Boots the app's router and lists which defined routes match each target URL.
 */
$targets = [
    'quote/printquote?orderid=6a9a66ae956b6'        => 'PRINTQUOTE',
    'purchaseinv/printpurchaseinv?orderid=6a72ba87c1d70' => 'PRINTPURCHASE',
    'proinv/printproinv?orderid=6a8eb60ca2ca4'    => 'PRINTPROINV',
    'account/getledger/1014'                          => 'GETLEDGER',
    'taxinv/printtaxinv?orderid=5e5332769bcd2'      => 'PRINTTAXINV',
];
$out = [];
try {
    define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);
    chdir(__DIR__);
    $minPHPVersion = '7.3';
    require realpath(FCPATH . 'app/Config/Paths.php');
    $paths = new Config\Paths();
    $bootstrap = rtrim($paths->systemDirectory, '\\/ ') . DIRECTORY_SEPARATOR . 'bootstrap.php';
    $app = require realpath($bootstrap);

    $routes = \Config\Services::routes();
    $routes->setHTTPVerb('get');
    $all = $routes->getRoutes('get');

    $out[] = 'PHP: ' . PHP_VERSION;
    $out[] = 'Total GET routes registered: ' . count($all);

    $out[] = '--- route status per URL ---';
    foreach ($targets as $url => $label) {
        $uri = strtok($url, '?');
        $uri = ltrim($uri, '/');
        $found = [];
        foreach ($all as $key => $val) {
            $k = ltrim($key, '/');
            if (preg_match('#^' . $k . '$#u', $uri)) {
                $found[] = $k . ' => ' . (is_array($val) ? json_encode($val) : (string) $val);
            }
        }
        $found = array_slice($found, 0, 10);
        $out[] = $label . ' [' . $url . '] => ' . (count($found) ? implode(' || ', $found) : '*** NO MATCH ***');
    }
} catch (\Throwable $e) {
    $out[] = 'EXCEPTION: ' . $e->getMessage() . ' @ ' . $e->getFile() . ':' . $e->getLine();
}
file_put_contents(__DIR__ . '/writable/diag_routes.txt', implode("\n", $out) . "\n");
echo "done\n";