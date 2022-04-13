<?php

namespace App\Controller\Admin;

use App\Entity\Manager;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ManagerCrudController extends AbstractCrudController
{
    private $passwordEncoder;

    public function __construct(UserPasswordHasherInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public static function getEntityFqcn(): string
    {
        return Manager::class;
   }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('firstName', 'Prénom'),
            TextField::new('lastName', 'Nom'),
            EmailField::new('email', 'E-mail'),
            TextField::new('password', 'Mot de passe')
                ->hideOnIndex()
                ->setRequired($pageName === Crud::PAGE_NEW)
                ->onlyOnForms()
                ->setFormType(PasswordType::class),
            ChoiceField::new('roles', 'Rôles')
                ->setChoices(['Manager' => "ROLE_MANAGER", 'Utilisateur' => "ROLE_USER"])
                ->allowMultipleChoices(true),
            AssociationField::new('establishment', 'Établissement')->renderAsNativeWidget()
        ];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->encodePassword($entityInstance);
        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->encodePassword($entityInstance);
        parent::updateEntity($entityManager, $entityInstance);
    }

    private function encodePassword(Manager $manager)
    {
        if ($manager->getPassword() !== null) {
            $manager->setPassword($this->passwordEncoder->hashPassword($manager, $manager->getPassword()));
        }
    }
}
