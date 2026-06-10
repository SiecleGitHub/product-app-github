<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class UserCrudController extends AbstractCrudController
{
    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $password_field = TextField::new('plainPassword', 'Password')
                            ->setFormType(PasswordType::class)
                            ->onlyOnForms()
                            ->setRequired($pageName === Crud::PAGE_NEW);

        if ($pageName === Crud::PAGE_EDIT) {
            $password_field->setHelp(
                'Leave blank to keep the current password'
            );
        }

        $roles = ChoiceField::new('roles')
                    ->setChoices([
                        'User' => 'ROLE_USER',
                        'Admin' => 'ROLE_ADMIN'
                    ])
                    ->allowMultipleChoices()
                    ->renderExpanded()
                    ->onlyOnForms();

        return [
            TextField::new('name'),
            EmailField::new('email'),
            BooleanField::new('is_verified'),
            $password_field,
            $roles
        ];
    }

    public function persistEntity(EntityManagerInterface $entityManager,
                                  $entityInstance): void
    {
        $entityInstance->setPassword(
            $this->hasher->hashPassword(
                $entityInstance,
                $entityInstance->getPlainPassword()
            )
        );

        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager,
                                 $entityInstance): void
    {
        if ($entityInstance->getPlainPassword()) {
            $entityInstance->setPassword(
                $this->hasher->hashPassword(
                    $entityInstance,
                    $entityInstance->getPlainPassword()
                )
            );
        }

        parent::updateEntity($entityManager, $entityInstance);
    }
}
