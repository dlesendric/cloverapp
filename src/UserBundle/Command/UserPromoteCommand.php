<?php

namespace UserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class UserPromoteCommand extends ContainerAwareCommand
{
    protected function configure()
    {
	    $this
		    ->setName('user:promote')
		    ->setDescription('Promotes a user by adding a role')
		    ->setHelp(<<<'EOT'
The <info>user:promote</info> command promotes a user by adding a role

  <info>php %command.full_name% admin ROLE_CUSTOM</info>
  <info>php %command.full_name% --super admin</info>
EOT
		    )
		    ->addArgument('username', InputArgument::OPTIONAL, 'User username')
		    ->addArgument('role', InputArgument::OPTIONAL, 'User role')
	    ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $username = $input->getArgument('username');
		$role = $input->getArgument('role');
		$service = $this->getContainer()->get('user_service');
		$repo = $service->getRepository();
		$user = $repo->findOneBy([
			'username'=>$username
		]);
		if(!$user){
			throw new \Exception('User not found');
		}
		$user->addRole($role);
		$service->save($user,true);

        $output->writeln('USER PROMOTED!');
    }



	/**
	 * {@inheritdoc}
	 */
	protected function interact(InputInterface $input, OutputInterface $output)
	{
		$questions = array();

		if (!$input->getArgument('username')) {
			$question = new Question('Please choose a username:');
			$question->setValidator(function ($username) {
				if (empty($username)) {
					throw new \Exception('Username can not be empty');
				}

				return $username;
			});
			$questions['username'] = $question;
		}

		if (!$input->getArgument('role')) {
			$question = new Question('Please choose a role:');
			$question->setValidator(function ($role) {
				if (empty($role)) {
					throw new \Exception('Role can not be empty');
				}

				return $role;
			});
			$questions['role'] = $question;
		}

		foreach ($questions as $name => $question) {
			$answer = $this->getHelper('question')->ask($input, $output, $question);
			$input->setArgument($name, $answer);
		}
	}
}
