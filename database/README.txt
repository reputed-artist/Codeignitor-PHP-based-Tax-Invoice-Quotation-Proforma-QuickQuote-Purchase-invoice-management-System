Place your database dump here as:

    install.sql

The installer's "Database Import" step imports this file automatically
when "Use default database schema" is selected.

Notes:
- Plain .sql text dump (e.g. exported with mysqldump or phpMyAdmin).
- .zip uploads are also supported from the wizard (contains .sql inside).
- Large dumps are fine: the installer splits the file into individual
  statements before executing, so it no longer trips MySQL's
  max_allowed_packet limit.
