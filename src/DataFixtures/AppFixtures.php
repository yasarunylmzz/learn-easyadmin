<?php

namespace App\DataFixtures;

use App\Entity\BlogPost;
use App\Entity\Tag;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher) {}

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $blogPost = new BlogPost();
        $tag = new Tag();


        $tag->setName('PHP');
        $manager->persist($tag);

        $user->setEmail('yasarunylmzz@gmail.com');
        $user->setPassword($this->passwordHasher->hashPassword($user, '123456'));
        $user->setRoles(['ROLE_USER']);
        $manager->persist($user);


        $blogPost->setTitle('Blog Post 1');
        $blogPost->setDescription('Blog Post Description 1');
        $blogPost->setAuthor($user);
        $blogPost->addTag($tag);
        $blogPost->setCreatedAt(new \DateTimeImmutable());
        $blogPost->setSlug('blog-post-1');
        $manager->persist($blogPost);

        $manager->flush();
    }
}
