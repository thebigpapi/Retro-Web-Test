<?php

namespace App\BranchLoader;

class GitLoader
{
    private $projectDir;

    public function __construct($projectDir)
    {
        $this->projectDir = $projectDir;
    }

    public function getBranchName()
    {
        $gitHeadFile = $this->projectDir . '/.git/HEAD';
        $branchname = 'no branch name';

        $stringFromFile = file_exists($gitHeadFile) ? file($gitHeadFile, FILE_USE_INCLUDE_PATH) : "";

        if (isset($stringFromFile) && is_array($stringFromFile)) {
            //get the string from the array
            $firstLine = $stringFromFile[0];
            //seperate out by the "/" in the string
            $explodedString = explode("/", $firstLine, 3);

            $branchname = trim($explodedString[2]);
        }

        return $branchname;
    }

    public function getLastCommitMessage()
    {
        $gitCommitMessageFile = $this->projectDir . '/.git/COMMIT_EDITMSG';
        $commitMessage = file_exists($gitCommitMessageFile) ? file($gitCommitMessageFile, FILE_USE_INCLUDE_PATH) : "";

        return \is_array($commitMessage) ? trim($commitMessage[0]) : "";
    }

    public function getLastCommitDetail()
    {
        $logs = [];
        $gitLogFile = $this->projectDir . '/.git/logs/HEAD';
        $gitLogs = file_exists($gitLogFile) ? file($gitLogFile, FILE_USE_INCLUDE_PATH) : "";

        $logExploded = [];
        if (is_array($gitLogs))
            $logExploded = explode(' ', end($gitLogs));
        elseif (is_string($gitLogs))
            $logExploded = explode(' ', $gitLogs);
        $logs['author'] = $logExploded[2] ?? 'not defined';
        $logs['date'] = isset($logExploded[4]) ? date('Y/m/d H:i', intval($logExploded[4])) : "not defined";

        return $logs;
    }

    public function getCurrentCommitHash()
    {
        $gitHeadRefFile = $this->projectDir . '/.git/refs/heads/' . $this->getBranchName();
        $commitHash = "unknown";
        
        $stringFromFile = file_exists($gitHeadRefFile) ? file($gitHeadRefFile, FILE_USE_INCLUDE_PATH) : "";

        if (isset($stringFromFile) && is_array($stringFromFile)) {
            //get the string from the array
            $firstLine = $stringFromFile[0];
            $commitHash = substr(trim($firstLine), 0, 8);
        }

        return $commitHash;

    }
}
