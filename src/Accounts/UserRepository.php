<?php namespace Lio\Accounts;

use Lio\Core\EloquentRepository;
use Lio\Core\Exceptions\EntityNotFoundException;
use Lio\Github\GithubUser;

class UserRepository extends EloquentRepository
{
    public function __construct(Member $model)
    {
        $this->model = $model;
    }

    public function getByGithubId($id)
    {
        return $this->model->where('github_id', '=', $id)->first();
    }

    public function requireByName($name)
    {
        $model = $this->getByName($name);

        if ( ! $model) {
            throw new EntityNotFoundException("User with name {$name} could not be found.");
        }

        return $model;
    }

    public function getByName($name)
    {
        return $this->model->where('name', '=', $name)->first();
    }

    public function getFirstX($count)
    {
        return $this->model->take($count)->get();
    }

    public function getGithubUser(GithubUser $user)
    {
        return $this->getByGithubId($user->githubId);
    }
}
