phpmd is based on PMD.

Usage:

php phpmd.phar <file_name> <report_format> <rulesets>

Available formats: ansi, baseline, checkstyle, github, html, json, sarif, text, xml.
Available rulesets: cleancode, codesize, controversial, design, naming, unusedcode.

Optional arguments that may be put after the mandatory arguments:
--minimumpriority: rule priority threshold; rules with lower priority than this will not be used
--reportfile: send report output to a file; default to STDOUT
--suffixes: comma-separated string of valid source code filename extensions, e.g. php,phtml
--exclude: comma-separated string of patterns that are used to ignore directories. Use asterisks to exclude by pattern. For 
example *src/foo/*.php or *src/foo/*
--strict: also report those nodes with a @SuppressWarnings annotation
--ignore-errors-on-exit: will exit with a zero code, even on error
--ignore-violations-on-exit: will exit with a zero code, even if any violations are found
--generate-baseline: will generate a phpmd.baseline.xml next to the first ruleset file location
--update-baseline: will remove any non-existing violations from the phpmd.baseline.xml
--baseline-file: a custom location of the baseline file