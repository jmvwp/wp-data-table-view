<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace MVWP\WPDataTableView\Tests\Unit\Providers;

use MVWP\WPDataTableView\Abstracts\AbstractEntity;
use MVWP\WPDataTableView\Exceptions\EntityGenerationException;
use MVWP\WPDataTableView\Providers\DataRepository;
use MVWP\WPDataTableView\Providers\JSONPlaceholder\Entities\User;
use MVWP\WPDataTableView\Providers\JSONPlaceholder\Entities\UserFactory;
use MVWP\WPDataTableView\Providers\JSONPlaceholder\Provider;
use MVWP\WPDataTableView\Tests\Unit\AbstractUnitTestcase;

class DataRepositoryTest extends AbstractUnitTestcase
{

    public function testGetAllShouldReturnEmptyArrayIfNoDataFromProvider()
    {
        $providerMock = $this->getProviderMock();
        $entityFactoryMock = $this->getEntityFactoryMock();
        $providerMock->method('allData')->willReturn([]);
        $repository = new DataRepository($providerMock, $entityFactoryMock);

        $result = $repository->all();
        $this->assertEquals([], $result);
    }

    public function testGetAllShouldReturnArrayOfEntitiesIfDataGotFromProvider()
    {
        $providerMock = $this->getProviderMock();
        $entityFactoryMock = $this->getEntityFactoryMock();
        $providerData = json_decode($this->getJsonFromFixtures('jsonPlaceholderApiResponseAll'), true);
        $providerMock->method('allData')->willReturn($providerData);
        $entityFactoryMock->method('create')->willReturn(new User());
        $repository = new DataRepository($providerMock, $entityFactoryMock);

        $result = $repository->all();
        foreach ($result as $item) {
            $this->assertInstanceOf(AbstractEntity::class, $item);
        }
    }

    public function testGetAllShouldReturnEmptyArrayIfEntityCreationThrowException()
    {
        $providerMock = $this->getProviderMock();
        $entityFactoryMock = $this->getEntityFactoryMock();
        $providerData = json_decode($this->getJsonFromFixtures('jsonPlaceholderApiResponseAll'), true);
        $providerMock->method('allData')->willReturn($providerData);
        $entityFactoryMock->method('create')->willThrowException(new EntityGenerationException());
        $repository = new DataRepository($providerMock, $entityFactoryMock);

        $result = $repository->all();
        $this->assertEquals([], $result);
    }

    public function testGetEntityByIdShouldReturnNullIfNoDataFromProvider()
    {
        $entityId = 1;
        $providerMock = $this->getProviderMock();
        $entityFactoryMock = $this->getEntityFactoryMock();
        $providerMock->method('itemDataByID')->willReturn([]);
        $repository = new DataRepository($providerMock, $entityFactoryMock);

        $result = $repository->entityById($entityId);
        $this->assertNull($result);
    }

    public function testGetEntityByIdShouldEntityIfDataGotFromProvider()
    {
        $entityId = 1;
        $providerMock = $this->getProviderMock();
        $entityFactoryMock = $this->getEntityFactoryMock();
        $providerData = json_decode($this->getJsonFromFixtures('jsonPlaceholderApiResponseOne'), true);
        $providerMock->method('itemDataByID')->willReturn($providerData);
        $entityFactoryMock->method('create')->willReturn(new User());
        $repository = new DataRepository($providerMock, $entityFactoryMock);

        $result = $repository->entityById($entityId);
        $this->assertInstanceOf(AbstractEntity::class, $result);
    }

    public function testGetEntityByIdShouldReturnNullIfEntityCreationThrowException()
    {
        $entityId = 1;
        $providerMock = $this->getProviderMock();
        $entityFactoryMock = $this->getEntityFactoryMock();
        $providerData = json_decode($this->getJsonFromFixtures('jsonPlaceholderApiResponseOne'), true);
        $providerMock->method('itemDataByID')->willReturn($providerData);
        $entityFactoryMock->method('create')->willThrowException(new EntityGenerationException());
        $repository = new DataRepository($providerMock, $entityFactoryMock);

        $result = $repository->entityById($entityId);
        $this->assertNull($result);
    }

    protected function getProviderMock()
    {
        return $this->createMock(Provider::class);
    }

    protected function getEntityFactoryMock()
    {
        return $this->createMock(UserFactory::class);
    }

}