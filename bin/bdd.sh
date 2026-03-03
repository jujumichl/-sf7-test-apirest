bin/console doctrine:database:drop --force
bin/console doctrine:database:create
bin/console doctrine:schema:update --force
bin/console doctrine:query:sql "$(<bdd/sf7-gsbfrais-data-eval.sql)"