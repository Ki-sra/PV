<#
  Optional cleanup script for the repository.
  Runs only when executed explicitly by the user. It will delete the Django scaffold folder `ista_pv/` and some optional files.
  Use with caution.
#>

param()

$root = Split-Path -Parent $MyInvocation.MyCommand.Definition
Write-Output "Repository root: $root"

function Confirm-Delete([string]$path) {
    if (Test-Path $path) {
        Write-Output "About to remove: $path"
        $c = Read-Host "Type YES to confirm deletion of this path"
        if ($c -eq 'YES') {
            Remove-Item -Recurse -Force $path
            Write-Output "Removed: $path"
        } else {
            Write-Output "Skipped: $path"
        }
    } else {
        Write-Output "Path not found (skipping): $path"
    }
}

Write-Output "This script will remove optional legacy files. It asks for confirmation per item."

# Items to remove
$items = @(
    Join-Path $root 'ista_pv',
    Join-Path $root 'ista_pv\requirements.txt'
)

foreach ($it in $items) { Confirm-Delete $it }

Write-Output "Cleanup script finished. If you removed files, commit and push the changes to your remote if desired."
