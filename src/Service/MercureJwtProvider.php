<?php

namespace App\Service;

use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;

class MercureJwtProvider
{
    private Configuration $configuration;

    public function __construct(string $jwtSecret)
    {

        $this->configuration = Configuration::forSymmetricSigner(
            new Sha256(),
            \Lcobucci\JWT\Signer\Key\InMemory::plainText($jwtSecret)
        );
    }

    public function createSubscriberToken(array $topics = []): string
    {

        return $this->configuration->builder()
            ->withClaim('mercure', ['subscribe' => $topics])
            ->getToken(
                $this->configuration->signer(),
                $this->configuration->signingKey()
            )
            ->toString();

    }

    public function createPublisherToken(array $topics): string
    {
        return $this->configuration->builder()
            ->withClaim('mercure', ['publish' => $topics])
            ->getToken(
                $this->configuration->signer(),
                $this->configuration->signingKey()
            )
            ->toString();
    }
}
