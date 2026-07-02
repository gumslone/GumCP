#!/bin/bash
# Local mirror of the CI PHP 7.0 compatibility check.
# Run before committing PHP changes:  bash scripts/check-php70.sh
#
# php -l on a newer local PHP does NOT catch 7.1+ syntax, so this greps for the
# known offenders (nullable types, `: void`) across first-party files.
set -u

cd "$(dirname "$0")/.." || exit 1

if grep -rnE ':[[:space:]]*void|\([[:space:]]*\?[a-zA-Z]|,[[:space:]]*\?[a-zA-Z]|:[[:space:]]*\?[a-zA-Z]' \
     --include='*.php' . | grep -v '/modules/'; then
    echo ""
    echo "✗ Found PHP 7.1+ syntax (nullable type or ': void'). Target is PHP 7.0 — fix before committing."
    exit 1
fi

echo "✓ No PHP 7.1+ syntax found — first-party code is PHP 7.0 compatible."
