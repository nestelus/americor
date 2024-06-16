<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Infrastructure\Notifications\Interfaces\EmailSenderInterface;
use App\Infrastructure\Notifications\Interfaces\SmsSenderInterface;
use App\Infrastructure\Notifications\Senders\EmailSender;
use App\Infrastructure\Notifications\Senders\SmsSender;
use Yii;
use yii\base\BootstrapInterface;
use yii\di\Container;
use yii\di\Instance;
use App\Application\Services\ClientService;
use App\Application\Services\LoanService;
use App\Domains\Clients\Repositories\ClientRepositoryInterface;
use App\Domains\Loans\Repositories\LoanRepositoryInterface;
use App\Infrastructure\Persistence\Repositories\ClientRepository;
use App\Infrastructure\Persistence\Repositories\LoanRepository;
use App\Infrastructure\Notifications\EmailNotifier;
use App\Infrastructure\Notifications\SmsNotifier;

class Yii2App implements BootstrapInterface
{
    public function bootstrap($app)
    {
        // Настройка контейнера зависимостей
        Yii::$container->setSingleton(ClientRepositoryInterface::class, ClientRepository::class);
        Yii::$container->setSingleton(LoanRepositoryInterface::class, LoanRepository::class);
        Yii::$container->setSingleton(EmailNotifier::class, function (Container $container, $params, $config) {
            return new EmailNotifier(
                Instance::ensure(EmailSender::class)
            );
        });
        Yii::$container->setSingleton(SmsNotifier::class, function (Container $container, $params, $config) {
            return new SmsNotifier(
                Instance::ensure(SmsSender::class)
            );
        });
        Yii::$container->setSingleton(ClientService::class, function (Container $container, $params, $config) {
            return new ClientService(
                Instance::ensure(ClientRepositoryInterface::class)
            );
        });
        Yii::$container->setSingleton(LoanService::class, function (Container $container, $params, $config) {
            return new LoanService(
                Instance::ensure(LoanRepositoryInterface::class),
                Instance::ensure(EmailNotifier::class),
                Instance::ensure(SmsNotifier::class),
            );
        });
    }
}
