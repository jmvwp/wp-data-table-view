<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace MVWP\WPDataTableView\Tests\Unit\Providers\JSONPlaceholder\Entities;

use MVWP\WPDataTableView\Exceptions\EntityGenerationException;
use MVWP\WPDataTableView\Providers\JSONPlaceholder\Entities\Address;
use MVWP\WPDataTableView\Providers\JSONPlaceholder\Entities\Company;
use MVWP\WPDataTableView\Providers\JSONPlaceholder\Entities\Geo;
use MVWP\WPDataTableView\Providers\JSONPlaceholder\Entities\User;
use MVWP\WPDataTableView\Providers\JSONPlaceholder\Entities\UserFactory;
use MVWP\WPDataTableView\Tests\Unit\AbstractUnitTestCase;

class UserFactoryTest extends AbstractUnitTestCase
{

    public function testCreateShouldThrowExceptionIfWrongData()
    {
        $factory = new UserFactory();
        $this->expectException(EntityGenerationException::class);
        $factory->create([]);
        $factory->create([ 'wrong_key' => 'Wrong value' ]);
    }

    /**
     * @throws EntityGenerationException
     */
    public function testCreateShouldReturnEntityIfDataIsOk()
    {

        $factory = new UserFactory();
        $entityData = json_decode($this->getJsonFromFixtures('jsonPlaceholderApiResponseOne'), true);
        $result = $factory->create($entityData);
        $this->assertInstanceOf(User::class, $result);
        $this->assertSame(absint($entityData['id']), $result->id());
        $this->assertSame($entityData['name'], $result->name());
        $this->assertSame($entityData['username'], $result->username());
        $this->assertSame($entityData['email'], $result->email());
        $this->assertSame($entityData['phone'], $result->phone());
        $this->assertSame($entityData['website'], $result->website());
        $expectedCompany = new Company();
        $expectedCompany->changeName($entityData['company']['name']);
        $expectedCompany->changeCatchPhrase($entityData['company']['catchPhrase']);
        $expectedCompany->changeBs($entityData['company']['bs']);
        $this->assertEquals($expectedCompany, $result->company());

        $expectedAddress = new Address();
        $expectedAddress->changeCity($entityData['address']['city']);
        $expectedAddress->changeStreet($entityData['address']['street']);
        $expectedAddress->changeSuite($entityData['address']['suite']);
        $expectedAddress->changeZipcode($entityData['address']['zipcode']);
        $expectedGeo = new Geo();
        $expectedGeo->changeLat($entityData['address']['geo']['lat']);
        $expectedGeo->changeLng($entityData['address']['geo']['lng']);
        $expectedAddress->changeGeo($expectedGeo);

        $this->assertEquals($expectedAddress, $result->address());
    }

}