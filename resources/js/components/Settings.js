import React from 'react';
import ReactDOM from 'react-dom';
import TrackingButton from './TrackingButton';
import DailyAdheranceView from './DailyAdheranceView';
import NextCalendarEvent from './NextCalendarEvent';

import { PieChart } from 'react-minimal-pie-chart';

class Settings extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
        }
    }



    render() {
        return (
            <div className="p-5 m-auto w-10/12 text-center">
                <h1>Welcome to settings</h1>
            </div>
        );
    }

}

export default Settings;

if (document.getElementById('settings')) {
    ReactDOM.render(<Settings />, document.getElementById('settings'));
}
