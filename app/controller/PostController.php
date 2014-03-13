<?php
namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

class PostController
{

	protected $repo;
	
	public function __construct(PostRepository $repo)
	{
		$this->repo = $repo;
	}

	public function indexJsonAction()
	{
		return new JsonResponse($this->repo->findAll());
	}
}