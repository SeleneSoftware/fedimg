<?php

namespace App\Command;

use App\Entity\Profile;
use App\Entity\Setting;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'install:new',
    description: 'Installer for a New FedImg Instance',
)]
class InstallNewCommand extends Command
{
    protected $doctrine;

    protected $user;

    protected $hasher;

    public function __construct(ManagerRegistry $doctrine, UserRepository $user, UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->hasher = $userPasswordHasher;
        $this->user = $user;
        $this->doctrine = $doctrine;
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = new SymfonyStyle($input, $output);

        // $helper = $this->getHelper('question');
        $db = $this->databaseOptions($helper);

        $question = $helper->confirm('Require Email Validation at register?', false);

        if ($question) {
            echo 'Not Yet';
            $email['verify'] = false;
        } else {
            $email['verify'] = false;
        }

        $this->createEnv([
            'database' => $db,
            'email' => $email,
        ]);

        $migrate = $this->runDoctrine($output);

        $this->siteOptions($helper);
        $this->createUser($helper);
        $this->emailSettings($email);

        $helper->success('Your new FedImg instance is now installed.  Post Away!');

        return Command::SUCCESS;
    }

    private function createUser(SymfonyStyle $helper)
    {
        $ue = $helper->ask('Admin Email Address', 'admin@example.com');
        $un = $helper->ask('Admin Username', 'admin');
        $up = $helper->ask('Admin Password', 'PassWord123!');

        $usr = new User();
        $usr->setEmail($ue)
            ->setUsername($un)
            ->addRole('ROLE_ADMIN')
            ->setProfile(new Profile())
            ->setPassword($this->hasher->hashPassword(
                $usr,
                $up
            )
            )
        ;

        $this->user->save($usr, true);
    }

    private function databaseOptions(SymfonyStyle $helper): array
    {
        $db['Host'] = $helper->ask('Enter Database Host', '127.0.0.1');
        // $db['Host'] = $helper->ask($input, $output, $question);
        $db['Port'] = $helper->ask('Enter Database Port', '3306');
        // $db['Port'] = $helper->ask($input, $output, $question);
        $db['Name'] = $helper->ask('Enter Database Name', 'fedimg');
        // $db['Name'] = $helper->ask($input, $output, $question);
        $db['User'] = $helper->ask('Enter Database User', 'fedimg');
        // $db['User'] = $helper->ask($input, $output, $question);
        $db['Pass'] = $helper->ask('Enter Database Name', 'PassWord1');
        // $db['Pass'] = $helper->ask($input, $output, $question);

        return $db;
    }

    private function siteOptions($helper)
    {
        $repo = $this->doctrine->getRepository(Setting::class);

        // $question = new Question('Enter FedImg Site name', 'FedImg');
        $repo->add('sitename', $helper->ask('Enter FedImg Site name', 'FedImg'));
        // $question = new Question('Enter FedImg Site nickname', 'FedImg');
        $repo->add('sitenick', $helper->ask('Enter FedImg Site nickname', 'FedImg'));
        // $question = new Question('Enter FedImg Site description', 'My New FedImg Instance');
        $repo->add('sitedesc', $helper->ask('Enter FedImg Site description', 'My New FedImg Instance'));

        // Just putting this here because no email verifications yet
        $repo->add('emailverify', 'no', true);
    }

    private function createEnv(array $db)
    {
        $filesystem = new Filesystem();

        try {
            // var_dump($db);
            // exit('what the hell');
            $filesystem->dumpFile(
                Path::normalize('.env.local'), "APP_ENV=prod\n".
                'DATABASE_URL="mysql://'
                .$db['database']['User']
                .':'
                .$db['database']['Pass']
                .'@'
                .$db['database']['Host']
                .':'
                .$db['database']['Port']
                .'/'
                .$db['database']['Name']
                .'?serverVersion=8&charset=utf8mb4"'
            );
        } catch (IOExceptionInterface $exception) {
            echo 'An error occurred while creating your directory at '.$exception->getPath();
        }
    }

    private function runDoctrine($output)
    {
        $command = $this->getApplication()->find('doctrine:migration:migrate');

        $arguments = [
            '--no-interaction',
        ];

        $greetInput = new ArrayInput($arguments);
        $returnCode = $command->run($greetInput, $output);
    }

    private function emailSettings(array $email)
    {
        // This just sits here until I have email verification actually done
    }
}
