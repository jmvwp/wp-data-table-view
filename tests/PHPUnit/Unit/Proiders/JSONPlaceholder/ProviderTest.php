<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace MVWP\WPDataTableView\Tests\Unit\Providers\JSONPlaceholder;

use Brain\Monkey\Expectation\Exception\ExpectationArgsRequired;
use MVWP\WPDataTableView\ObjectCache;
use MVWP\WPDataTableView\Providers\JSONPlaceholder\Provider;
use MVWP\WPDataTableView\Tests\Unit\AbstractUnitTestcase;
use Brain\Monkey\Functions;

class ProviderTest extends AbstractUnitTestcase
{

    protected function getCacheMock()
    {
        return $this->createMock(ObjectCache::class);
    }

    public function testGetAllShouldReturnCachedData()
    {
        $cacheMock = $this->getCacheMock();
        $cachedData = json_decode($this->getJsonFromFixtures('jsonPlaceholderApiResponseAll'), true);
        $cacheMock->method('get')->willReturn($cachedData);

        $provider = new Provider($cacheMock);
        $result = $provider->allData();

        $this->assertEqualsCanonicalizing($cachedData, $result);
    }

    /**
     * @throws ExpectationArgsRequired
     */
    public function testGetAllShouldDoRequestIfCacheIsEmpty()
    {
        $cacheMock = $this->getCacheMock();
        $cacheMock->method('get')->willReturn(false);
        $apiData = json_decode($this->getJsonFromFixtures('jsonPlaceholderApiResponseAll'), true);
        Functions\when('wp_remote_retrieve_body')->justReturn(json_encode($apiData));
        Functions\when('wp_remote_retrieve_response_code')->justReturn(200);
        Functions\expect('wp_remote_get')->once()->with(Provider::API_URL . '/users');
        $cacheMock->expects($this->once())->method('set')->with(Provider::CACHE_KEY, $apiData);

        $provider = new Provider($cacheMock);
        $result = $provider->allData();

        $this->assertEqualsCanonicalizing($apiData, $result);
    }

    public function testGetAllShouldReturnEmptyArrayIfAPIDoesntWork()
    {
        $cacheMock = $this->getCacheMock();
        $cacheMock->method('get')->willReturn(false);
        Functions\when('wp_remote_retrieve_body')->justReturn('');
        Functions\when('wp_remote_retrieve_response_code')->justReturn(500);
        Functions\stubs([ 'wp_remote_get' ]);
        $provider = new Provider($cacheMock);
        $result = $provider->allData();

        $this->assertEqualsCanonicalizing([], $result);
    }

    public function testGetItemDataByIDShouldReturnCachedData()
    {
        $entityId = 1;
        $cacheMock = $this->getCacheMock();
        $cachedData = json_decode($this->getJsonFromFixtures('jsonPlaceholderApiResponseOne'), true);
        $cacheMock->method('get')->willReturn($cachedData);

        $provider = new Provider($cacheMock);
        $result = $provider->itemDataByID($entityId);

        $this->assertEqualsCanonicalizing($cachedData, $result);
    }

    /**
     * @throws ExpectationArgsRequired
     */
    public function testGetItemDataByIDShouldDoRequestIfCacheIsEmpty()
    {
        $entityId = 1;
        $cacheMock = $this->getCacheMock();
        $cacheMock->method('get')->willReturn(false);
        $apiData = json_decode($this->getJsonFromFixtures('jsonPlaceholderApiResponseOne'), true);
        Functions\when('wp_remote_retrieve_body')->justReturn(json_encode($apiData));
        Functions\when('wp_remote_retrieve_response_code')->justReturn(200);
        Functions\expect('wp_remote_get')->once()->with(Provider::API_URL . '/users/' . $entityId);
        $cacheMock->expects($this->once())->method('set')->with(Provider::CACHE_KEY . $entityId, $apiData);

        $provider = new Provider($cacheMock);
        $result = $provider->itemDataByID($entityId);

        $this->assertEqualsCanonicalizing($apiData, $result);
    }

    public function testGetItemDataByIDShouldReturnEmptyArrayIfAPIDoesntWork()
    {
        $entityId = 1;
        $cacheMock = $this->getCacheMock();
        $cacheMock->method('get')->willReturn(false);
        Functions\when('wp_remote_retrieve_body')->justReturn('');
        Functions\when('wp_remote_retrieve_response_code')->justReturn(500);
        Functions\stubs([ 'wp_remote_get' ]);
        $provider = new Provider($cacheMock);
        $result = $provider->itemDataByID($entityId);

        $this->assertEqualsCanonicalizing([], $result);
    }

}