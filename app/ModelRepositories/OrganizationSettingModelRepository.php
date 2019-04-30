<?php
namespace App\ModelRepositories;

// Models
use App\Models\OrganizationSetting;
use App\DomainValueObjects\UUIDGenerator\UUID;

// Interface
use App\ModelRepositoryInterfaces\OrganizationSettingModelRepositoryInterface;

// Exceptions
use App\Exceptions\OrganizationExceptions\OrganizationSettingHasEntryException;

class OrganizationSettingModelRepository implements OrganizationSettingModelRepositoryInterface
{ }
