<?php

use Illuminate\Support\Arr;
use Tests\Unit\DataTransferObjects\Fixtures\GenderEnum;
use Tests\Unit\DataTransferObjects\Fixtures\RoleData;
use Tests\Unit\DataTransferObjects\Fixtures\UserData;

it(description: 'can resolve From Array')
    ->tap(callable: function () {
        $data = UserData::resolveFromArray(data: [
            'name' => 'Stiven Katuuk',
            'roles' => null,
        ]);

        expect(value: $data->name)->toBe(expected: 'Stiven Katuuk');
    })
    ->group('unit', 'dto');

it(description: 'can map to sub dto as object')
    ->tap(callable: function () {
        $data = UserData::resolveFromArray(data: [
            'name' => 'Stiven Katuuk',
            'main_role' => ['name' => 'Moderator'],
        ]);

        expect(value: $data->mainRole)->toBeInstanceOf(class: RoleData::class);
    })
    ->group('unit', 'dto');

it(description: 'can map to sub dto as array')
    ->tap(callable: function () {
        $data = UserData::resolveFromArray(data: [
            'name' => 'Stiven Katuuk',
            'roles' => [
                ['name' => 'Admin'],
            ],
        ]);

        expect(value: Arr::first($data->roles))->toBeInstanceOf(class: RoleData::class);
    })
    ->group('unit', 'dto');

it(description: 'can map to int')
    ->tap(callable: function () {
        $data = UserData::resolveFromArray(data: [
            'age' => 19,
        ]);

        expect(value: $data->age)->toBeInt();
    })
    ->group('unit', 'dto');

it(description: 'can map to enum')
    ->tap(callable: function () {
        $data = UserData::resolveFromArray(data: [
            'gender' => GenderEnum::Female,
        ]);

        expect(value: $data->gender)->toBe(expected: GenderEnum::Female);
    })
    ->group('unit', 'dto');

it(description: 'can map array and can resolve the key')
    ->tap(callable: function () {
        $data = UserData::resolveFromArray(data: [
            'addresses' => [
                'main_address' => 'where',
                'main_address_1' => 'where',
            ],
        ]);

        expect(value: $data->addresses)->toMatchArray(array: [
            'mainAddress' => 'where',
            'mainAddress1' => 'where',
        ]);
    })
    ->group('unit', 'dto');
