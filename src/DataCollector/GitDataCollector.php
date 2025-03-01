<?php

//src/DataCollector/GitDataCollector.php
namespace App\DataCollector;

use App\BranchLoader\GitLoader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;

class GitDataCollector extends DataCollector
{
    private $gitLoader;

    public function __construct(GitLoader $gitLoader)
    {
        $this->gitLoader = $gitLoader;
    }

    /**
     * @return void
     */
    public function collect(Request $request, Response $response, \Throwable $exception = null)
    {
        // We add the git informations in $data[]
        $this->data = [
            'git_branch' => $this->gitLoader->getBranchName(),
            'git_commit' => $this->gitLoader->getCurrentCommitHash(),
            'last_commit_message' => $this->gitLoader->getLastCommitMessage(),
            'logs' => $this->gitLoader->getLastCommitDetail(),
        ];
    }

    // we will use this name in the config later
    /** 
     *
     * @return string
     */
    public function getName()
    {
        return 'app.git_data_collector';
    }

    /**
     * @return void
     */
    public function reset()
    {
        $this->data = array();
    }
    //Some helpers to access more easily to infos in the template
    public function getGitBranch()
    {
        return $this->data['git_branch'];
    }

    public function getGitCommit()
    {
        return $this->data['git_commit'];
    }

    public function getLastCommitMessage()
    {
        return $this->data['last_commit_message'];
    }

    public function getLastCommitAuthor()
    {
        return $this->data['logs']['author'];
    }

    public function getLastCommitDate()
    {
        return $this->data['logs']['date'];
    }
}
