<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Enum\Role;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class UserCrudController extends AbstractCrudController
{

    public function __construct(private UserPasswordHasherInterface $passwordHasher) {}

    public static function getEntityFqcn(): string
    {
        return User::class;
    }


    public function configureFields(string $pageName): iterable
    {
        $fields = [
            TextField::new('email'),
            TextField::new('password')->onlyOnForms()->setFormType(PasswordType::class),
            ChoiceField::new('roles')->setChoices([
                'Admin' => Role::Admin->value,
                'User' => Role::User->value,
            ])->allowMultipleChoices(),
        ];

        if ($pageName === Crud::PAGE_EDIT) {
            $fields[] = TextField::new('password')
                ->setFormType(PasswordType::class);
        }

        return $fields;
    }

    public function configureActions(Actions $actions): Actions
    {

        $resetPassword = Action::new('resetPassword', 'şifre sıfırla')
            ->linkToCrudAction('resetPasswordAction');

        return $actions->add(Crud::PAGE_INDEX, $resetPassword);
    }

    public function persistEntity(EntityManagerInterface $entityManager, object $entityInstance): void
    {

        $plainPassword = $entityInstance->getPassword();
        $hashedPassword = $this->passwordHasher->hashPassword($entityInstance, $plainPassword);
        $entityInstance->setPassword($hashedPassword);

        parent::persistEntity($entityManager, $entityInstance);
    }
}
