import React from 'react';
import ReactDOM from 'react-dom';
import TrackingButton from './TrackingButton';
import DailyAdheranceView from './DailyAdheranceView';
import NextCalendarEvent from './NextCalendarEvent';

import { PieChart } from 'react-minimal-pie-chart';

function Homepage() {
    var adheranceData = {
        Monday: true,
        Tuesday: true,
        Wednesday: false,
        Thursday: true,
        Friday: false,
        Saturday: true,
        Sunday: true,
    }

    return (
        <div className="p-5 m-auto w-10/12 text-center">
            <h2 className="font-seoulNamsan text-xl font-bold">Your Adherance for the last 7 days</h2>
            <PieChart
                className="m-auto mt-4 mb-4 w-1/5"
                data={[
                    { title: 'Time Completed', value: 85, color: '#a7f3d0' },
                    { title: 'Time left to go', value: 15, color: '#fda0a0' },
                ]}
                lineWidth={20}
                animate={true}
                labelPosition={0}
                label={() => {return '85%'}}
            />
            <h2 className="text-xl font-bold">14.5 hours a day on average</h2>
            <DailyAdheranceView data={adheranceData}/>
            <TrackingButton />
            <h2 className="mt-5 text-xl font-bold">What's Coming up...</h2>
            <NextCalendarEvent
                eventDetails={{
                    eventName: 'Meet With Physio',
                    eventDate: '24th Dec',
                    eventTime: '4pm',
                }}
            />
        </div>
    );
}

export default Homepage;

if (document.getElementById('homepage')) {
    ReactDOM.render(<Homepage />, document.getElementById('homepage'));
}
