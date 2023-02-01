<?php

declare(strict_types=1);

namespace SocialDB\Commands;

use SocialDB\Models\UserModel;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateUsers extends Command
{
    protected static $defaultName = 'social:generate-users';

    protected function configure()
    {
        $this
            ->setDescription('Create a new user')
            ->addArgument('number', InputArgument::REQUIRED, 'Number of generated users');

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $number = $input->getArgument('number');

        if (!is_numeric($number)) {
            $output->writeln('Wrong number format');

            return self::FAILURE;
        }

        $users = json_decode(file_get_contents("Data/users.json"));

        $lastUser = end($users);
        $userId = count($users) === 0 ? 0 : $lastUser->id;

        $output->writeln("Generated users");
        for ($i = 0; $i < $number; $i++) {
            $userId++;
            $user = $this->generateUser($userId);
            $users[] = $user;

            $displayedIsOnlineVariable = $user->online ? 'Yes' : 'No';
            $displayedGender = $user->gender === 0 ? 'Male' : 'Female';

            $output->writeln("Id: {$userId}, Name: {$user->name}, Gender: {$displayedGender}, IsOnline: {$displayedIsOnlineVariable}, Birthday: {$user->dateOfBirth}, LastVisit: {$user->lastVisit}");
        }


        file_put_contents('Data/users.json', json_encode($users));


        return self::SUCCESS;
    }

    private function generateDateFromRange(string $start, string $end, string $format = DATE_ATOM): string
    {
        return date($format, mt_rand(strtotime($start), strtotime($end)));
    }

    private function generateUser(int $userId): UserModel
    {
        $user = new UserModel();
        $user->id = $userId;
        $user->name = 'User' . $userId;
        $user->gender = rand(0, 1);
        $user->online = rand(0, 1) === 1;
        $user->dateOfBirth = $this->generateDateFromRange("1 January 1970", "1 January 2015");

        do {
            $lastVisit = $this->generateDateFromRange("1 January 2015", "1 March 2021");
        } while ($lastVisit < $user->dateOfBirth);

        $user->lastVisit = $lastVisit;


        return $user;
    }
}
