<?php

namespace App\Controller\Admin;

use App\Entity\BlogPost;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class BlogPostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return BlogPost::class;
    }


    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if($entityInstance->getAuthor() === null){
            $entityInstance->setAuthor($this->getUser());
        }
        parent::persistEntity($entityManager, $entityInstance);
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            AssociationField::new('tags')->setFormTypeOption('by_reference', true),
            TextEditorField::new('description'),
            DateTimeField::new('createdAt'),
            AssociationField::new('author'),
            SlugField::new('slug')->setTargetFieldName('title'),
        ];
    }
}
