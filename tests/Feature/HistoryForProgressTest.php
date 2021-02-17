<?php

namespace Tests\Feature;

use App\Models\BootsAndBarsTime;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class HistoryForProgressTest extends TestCase
{
    use DatabaseMigrations;

    public function test_it_gets_last_7_days_in_format()
    {
        $user = $this->createUserAndLogin();

        $expected = [];
        $startTime = Carbon::parse('2021-01-28 02:28:10');
        Carbon::setTestNow($startTime);

        // Need to add a weeks worth of data
        $newRow = new BootsAndBarsTime;
        $newRow->start_time =$startTime;
        $newRow->end_time = $startTime->addMinutes(15*60);
        $newRow->duration = 15*60;
        $newRow->user_id = $user->id;
        $newRow->tracking = false;
        $newRow->save();
        $expected['days'][] = $startTime->format('l');
        $expected['hours'][] = 15;

        $startTime->addDay();

        $newRow = new BootsAndBarsTime;
        $newRow->start_time =$startTime;
        $newRow->end_time = $startTime->addMinutes(12*60);
        $newRow->duration = 12*60;
        $newRow->user_id = $user->id;
        $newRow->tracking = false;
        $newRow->save();
        $expected['days'][] = $startTime->format('l');
        $expected['hours'][] = 12;

        $startTime->addDay();

        $newRow = new BootsAndBarsTime;
        $newRow->start_time =$startTime;
        $newRow->end_time = $startTime->addMinutes(10*60);
        $newRow->duration = 10*60;
        $newRow->user_id = $user->id;
        $newRow->tracking = false;
        $newRow->save();
        $expected['days'][] = $startTime->format('l');
        $expected['hours'][] = 10;

        $startTime->addDay();

        $newRow = new BootsAndBarsTime;
        $newRow->start_time = $startTime;
        $newRow->end_time = $startTime->addMinutes(16*60);
        $newRow->duration = 16*60;
        $newRow->user_id = $user->id;
        $newRow->tracking = false;
        $newRow->save();
        $expected['days'][] = $startTime->format('l');
        $expected['hours'][] = 16;

        $startTime->addDay();

        $newRow = new BootsAndBarsTime;
        $newRow->start_time =$startTime;
        $newRow->end_time = $startTime->addMinutes(18*60);
        $newRow->duration = 18*60;
        $newRow->user_id = $user->id;
        $newRow->tracking = false;
        $newRow->save();
        $expected['days'][] = $startTime->format('l');
        $expected['hours'][] = 18;

        $response = $this->get('/progress-so-far');
        $response->assertStatus(200);

        $this->assertSame($expected['days'], json_decode($response->getContent(), true)['days']);
        $this->assertSame($expected['hours'], json_decode($response->getContent(), true)['hours']);
    }

    public function test_it_gets_all_history()
    {
        $this->withoutExceptionHandling();
        $user = $this->createUserAndLogin();

        $expected = [];
        $startTime = Carbon::parse("15-02-2021 12:00:00");
        Carbon::setTestNow();

        // Need to add a weeks worth of data
        $newRow = new BootsAndBarsTime;
        $newRow->start_time = $startTime->subWeek();
        $newRow->end_time = $startTime->addMinutes(15*60);
        $newRow->duration = 15*60;
        $newRow->user_id = $user->id;
        $newRow->tracking = false;
        $newRow->save();
        $expected['days'][] = $startTime->format('l');
        $expected['hours'][] = 15;

        $startTime->subHours(15);
        $startTime->subDay();

        $newRow = new BootsAndBarsTime;
        $newRow->start_time =$startTime;
        $newRow->end_time = $startTime->addMinutes(12*60);
        $newRow->duration = 12*60;
        $newRow->user_id = $user->id;
        $newRow->tracking = false;
        $newRow->save();
        $expected['days'][] = $startTime->format('l');
        $expected['hours'][] = 12;

        $startTime->subHours(12);

        $newRow = new BootsAndBarsTime;
        $newRow->start_time =$startTime->subDays(2);
        $newRow->end_time = $startTime->addMinutes(10*60);
        $newRow->duration = 10*60;
        $newRow->user_id = $user->id;
        $newRow->tracking = false;
        $newRow->save();

        $startTime->subHours(10);

        $newRow = new BootsAndBarsTime;
        $newRow->start_time = $startTime;
        $newRow->end_time = $startTime->addMinutes(6*60);
        $newRow->duration = 6*60;
        $newRow->user_id = $user->id;
        $newRow->tracking = false;
        $newRow->save();
        $expected['days'][] = $startTime->format('l');
        $expected['hours'][] = 16;

        $expected['start_date'] = Carbon::parse('-2 weeks')->format('d-m-Y');
        $expected['end_date'] = Carbon::parse('-1 weeks')->format('d-m-Y');

        $response = $this->post('/timing-history', [
            'start_date' => '-2 weeks',
            'end_date' => '-1 week'
        ]);

        $response->assertStatus(200);

        $this->assertSame($expected['days'], json_decode($response->getContent(), true)['days']);
        $this->assertSame($expected['hours'], json_decode($response->getContent(), true)['hours']);
        $this->assertEqualsWithDelta(
            $expected['start_date'],
            Carbon::parse(json_decode($response->getContent(), true)['start_date'])->format('d-m-Y'),
            5
        );
        $this->assertEqualsWithDelta(
            $expected['end_date'],
            Carbon::parse(json_decode($response->getContent(), true)['end_date'])->format('d-m-Y'),
            5
        );
    }

    public function test_it_fails_with_no_data()
    {
        $this->createUserAndLogin();

        $startTime = Carbon::parse('2021-01-28 02:28:10');
        Carbon::setTestNow($startTime);

        $response = $this->get('/progress-so-far');
        $response->assertStatus(204);

        $this->assertSame('', $response->getContent());
    }

    public function test_it_gets_history_with_multiple_times_on_same_day() {
        $expected = [];

        $user = $this->createUserAndLogin();

        $startTime = Carbon::parse('2021-01-28 02:28:10');
        Carbon::setTestNow($startTime);

        // Need to add a weeks worth of data
        $newRow = new BootsAndBarsTime;
        $newRow->start_time =$startTime;
        $newRow->end_time = $startTime->addMinutes(10*60);
        $newRow->duration = 10*60;
        $newRow->user_id = $user->id;
        $newRow->tracking = false;
        $newRow->save();

        $newRow = new BootsAndBarsTime;
        $newRow->start_time =$startTime;
        $newRow->end_time = $startTime->addMinutes(6*60);
        $newRow->duration = 6*60;
        $newRow->user_id = $user->id;
        $newRow->tracking = false;
        $newRow->save();

        $expected['days'][] = $startTime->format('l');
        $expected['hours'][] = 16;

        $startTime->addDay();

        $newRow = new BootsAndBarsTime;
        $newRow->start_time =$startTime;
        $newRow->end_time = $startTime->addMinutes(10*60);
        $newRow->duration = 10*60;
        $newRow->user_id = $user->id;
        $newRow->tracking = false;
        $newRow->save();
        $expected['days'][] = $startTime->format('l');
        $expected['hours'][] = 10;

        $response = $this->get('/progress-so-far');
        $response->assertStatus(200);


        $this->assertSame($expected['days'], json_decode($response->getContent(), true)['days']);
        $this->assertSame($expected['hours'], json_decode($response->getContent(), true)['hours']);
    }

    public function test_it_gets_how_long_worn_for()
    {
        $user = $this->createUserAndLogin();
        $startTime = Carbon::now();
        Carbon::setTestNow($startTime);

        // set one for a few months ago
        $newRow = new BootsAndBarsTime;
        $newRow->start_time = $startTime->subMonth();
        $newRow->end_time = $startTime->addMinutes(15*60);
        $newRow->duration = 15*60;
        $newRow->user_id = $user->id;
        $newRow->tracking = false;
        $newRow->save();

        $startTime->subMinutes(15*60);
        $startTime->addMonth();

        // set one for a week ago to make sure it gets the right record
        $newRow = new BootsAndBarsTime;
        $newRow->start_time = $startTime->subWeek();
        $newRow->end_time = $startTime->addMinutes(1*60);
        $newRow->duration = 1*60;
        $newRow->user_id = $user->id;
        $newRow->tracking = false;
        $newRow->save();

        $startTime->addWeek();
        $startTime->subMinutes(60);

        $response = $this->get('/progress-so-far');
        $response->assertStatus(200);

        $actual = json_decode($response->getContent(), true);

        $this->assertSame(4, $actual['boots_worn_for']);
    }

    public function test_it_gets_total_daily_average()
    {
        $user = $this->createUserAndLogin();
        $startTime = Carbon::now();
        Carbon::setTestNow($startTime);

        // add a few days in a row
        $newRow = new BootsAndBarsTime;
        $newRow->start_time = $startTime;
        $newRow->end_time = $startTime->addMinutes(15*60);
        $newRow->duration = 15*60;
        $newRow->user_id = $user->id;
        $newRow->tracking = false;
        $newRow->save();

        $newRow = new BootsAndBarsTime;
        $newRow->start_time = $startTime;
        $newRow->end_time = $startTime->addMinutes(10*60);
        $newRow->duration = 10*60;
        $newRow->user_id = $user->id;
        $newRow->tracking = false;
        $newRow->save();

        $newRow = new BootsAndBarsTime;
        $newRow->start_time = $startTime;
        $newRow->end_time = $startTime->addMinutes(19*60);
        $newRow->duration = 19*60;
        $newRow->user_id = $user->id;
        $newRow->tracking = false;
        $newRow->save();

        $expected = ((15*60) + (10*60) + (19*60))/3;

        $response = $this->get('/progress-so-far');
        $response->assertStatus(200);

        $actual = json_decode($response->getContent(), true);

        $this->assertSame($expected, $actual['total_average']);
    }
}
