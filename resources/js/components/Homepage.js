import React from 'react';
import ReactDOM from 'react-dom';
import TrackingButton from './TrackingButton';

import { PieChart } from 'react-minimal-pie-chart';

function Homepage() {
    return (
        <div className="p-5 m-auto w-10/12 text-center">
            <h1>Your Adherance for the last 7 days</h1>
            <PieChart
                className="m-auto w-1/4"
                data={[
                    { title: 'Time Completed', value: 85, color: '#a7f3d0' },
                    { title: 'Time left to go', value: 15, color: '#fda0a0' },
                ]}
                lineWidth={20}
                animate={true}
                labelPosition={0}
                label={() => {return '85%'}}
            />
            <h2>14.5 hours a day on average</h2>
            <TrackingButton 
                text="Start"
            />
        </div>
    );
}

export default Homepage;

if (document.getElementById('homepage')) {
    ReactDOM.render(<Homepage />, document.getElementById('homepage'));
}
