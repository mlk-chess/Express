<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Console\Question\Question;

#[AsCommand(
    name: 'app:create:user',
    description: 'Command to create a new User',
)]
class CreateUserCommand extends Command
{
    /** @var UserPasswordHasherInterface $userPasswordHasher */
    private $userPasswordHasher;

    /** @var EntityManagerInterface $manager */
    private $manager;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $manager, string $name = null)
    {
        parent::__construct($name);

        $this->userPasswordHasher = $userPasswordHasher;
        $this->manager = $manager;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::OPTIONAL, 'Email of your new user')
            ->addOption('admin-user', null, InputOption::VALUE_NONE, 'active admin user')
            ->addOption('user', null, InputOption::VALUE_NONE, 'active user')
            ->addOption('company', null, InputOption::VALUE_NONE, 'active company')
            ->addOption('controller', null, InputOption::VALUE_NONE, 'active controller')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $helper = $this->getHelper('question');

        $user = new User();

        if ($email = $input->getArgument('email')) {
            $user->setEmail($email);
        }else{
            $question = new Question('Please enter the Email :', 'email');
            if ($email = $helper->ask($input, $output, $question)) {
                $user->setEmail($email);
            }
        }


        $question = new Question('Please enter the password : ', 'pwd');
        $question->setHidden(true);
        if ($pwd = $helper->ask($input, $output, $question)) {
            $user->setPlainPassword($pwd);
        }

        $user->setStatus(2);
        $user->setNewsletter(1);

        if ($input->getOption('admin-user')) {
            $user->setRoles(['ROLE_ADMIN']);
        }else if ($input->getOption('user')){
            $user->setRoles(["ROLE_CUSTOMER"]);
        }else if ($input->getOption('company')){
            $user->setRoles(["ROLE_COMPANY"]);
        }else $user->setRoles(["ROLE_CONTROLLER"]);

        

      

        $this->manager->persist($user);
        $this->manager->flush();

        $io->success('You have created your new User');

        return Command::SUCCESS;
    }
}
