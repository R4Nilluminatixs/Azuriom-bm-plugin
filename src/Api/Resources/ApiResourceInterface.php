<?php
declare(strict_types=1);

namespace Azuriom\Plugin\Battlemetrics\Api\Resources;

interface ApiResourceInterface
{
    public function fromApiRequest(array $data): self;
}
