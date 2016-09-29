<?php

use App\HomeStay\Apartment\Apartment;
use App\HomeStay\Apartment\ApartmentAreaSearchCondition;
use App\HomeStay\Apartment\ApartmentNearbySearchCondition;
use App\HomeStay\Apartment\ApartmentRepository;
use App\HomeStay\Apartment\Area;
use App\HomeStay\Apartment\Location;
use App\User;
use Carbon\Carbon;

class SearchServiceTest extends TestCase
{
    /**
     * @var ApartmentRepository
     */
    protected $repository;

    /**
     * @var User
     */
    protected $user;

    public function setUp()
    {
        parent::setUp();

        $this->repository   = new ApartmentRepository();

        \DB::table('apartments')->truncate();
        \DB::table('users')->truncate();
        \DB::table('reviews')->truncate();


        \DB::table('apartments')->insert([
            ['available_from' => Carbon::today()->subDays(3)->format('Y-m-d H:i:s'), 'available_to' => Carbon::today()->subDays(2)->format('Y-m-d H:i:s'), 'capacity_from' => 2, 'capacity_to' => 6, 'location' => with(new Location(1, 2))->toSql(), 'city' => 'Bac Giang', 'user_id' => 1],
            ['available_from' => Carbon::today()->subDays(2)->format('Y-m-d H:i:s'), 'available_to' => Carbon::today()->addDays(2)->format('Y-m-d H:i:s'), 'capacity_from' => 1, 'capacity_to' => 1, 'location' => with(new Location(1, 2))->toSql(), 'city' => 'Ho Chi Minh', 'user_id' => 2],
            ['available_from' => Carbon::today()->subDays(2)->format('Y-m-d H:i:s'), 'available_to' => Carbon::today()->addDays(2)->format('Y-m-d H:i:s'), 'capacity_from' => 2, 'capacity_to' => 6, 'location' => with(new Location(21.217803, 105.820313))->toSql(), 'city' => 'Ha Noi', 'user_id' => 2]
        ]);

        \DB::table('reviews')->insert([
            ['user_id' => 1, 'apartment_id' => 1, 'rate' => 3, 'comment' => 'say something'],
            ['user_id' => 1, 'apartment_id' => 1, 'rate' => 5, 'comment' => 'say something1'],
            ['user_id' => 2, 'apartment_id' => 2, 'rate' => 5, 'comment' => 'say something3'],
        ]);

        \DB::table('users')->insert([
            ['name' => 'Hai Ngo', 'email' => 'haingo6394@gmail.com', 'password' => '12345'],
            ['name' => 'Hai Ngo1', 'email' => 'haingo63941@gmail.com', 'password' => '12345'],
            ['name' => 'Hai Ngo2', 'email' => 'haingo63942@gmail.com', 'password' => '12345'],
        ]);

    }

    public function tearDown()
    {
        \DB::table('apartments')->truncate();
        \DB::table('users')->truncate();
        \DB::table('reviews')->truncate();

        parent::tearDown();
    }

    public function testNearbySearchWithDefinedCondition()
    {


        $condition = new ApartmentNearbySearchCondition(new Location(20.988929,105.872498), 100);

        $condition
            ->availableIn(Carbon::yesterday(), Carbon::today())
            ->hasCapacityFrom(3, 5)
        ;

        $result = $this->repository->find($condition);
        $this->assertEquals(1, $result->count());

        /** @var Apartment $foundApartment */
        $foundApartment = $result->first();

        $this->assertEquals(3, $foundApartment->getId());
        $this->assertLessThan(3, $foundApartment->getCapacityFrom());
        $this->assertGreaterThan(5, $foundApartment->getCapacityTo());
    }

    public function testAreaSearch()
    {
        $condition = new ApartmentAreaSearchCondition();

        $condition
            ->availableIn(Carbon::yesterday(), Carbon::today())
            ->hasCapacityFrom(3, 5)
            ->in(new Area('Bac Giang'));
        ;

        $result = $this->repository->find($condition);
        $this->assertEquals(1, $result->count());
        $foundApartment = $result->first();

        $this->assertEquals(1, $foundApartment->getId());
        $this->assertLessThan(3, $foundApartment->getCapacityFrom());
        $this->assertGreaterThan(5, $foundApartment->getCapacityTo());
    }
}