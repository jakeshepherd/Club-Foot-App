import React from 'react';
import ReactDOM from 'react-dom';
import TrackingButton from './TrackingButton';
import DailyAdherenceView from './DailyAdherenceView';
import NextCalendarEvent from './NextCalendarEvent';

import { PieChart } from 'react-minimal-pie-chart';

class Homepage extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            averageDuration: '',
            weeklyAdherence: {},
            weeklyAdherencePercent: 0,
        }
    }

    async componentDidMount() {
        await axios.get(`/get-7-day-average`)
            .then(r => this.setState({
                averageDurationHours: Math.floor(r.data / 60),
                averageDurationMinutes: r.data % 60
            }))
        await axios.get(`/weekly-adherence`)
            .then(r => this.setState({
                    weeklyAdherence: r.data
            }))

        const totalSize = Object.keys(this.state.weeklyAdherence).length;
        const numOfTrues = Object.values(this.state.weeklyAdherence).filter(Boolean).length;
        this.setState({
            weeklyAdherencePercent: Math.round((numOfTrues/totalSize)*100)
        })
    }

    render() {
        return (
            <div className="p-5 m-auto w-10/12 text-center">
                <h2 className="font-seoulNamsan text-xl font-bold">Your Adherance for the last 7 days</h2>
                <PieChart
                    className="m-auto mt-4 mb-4 w-1/5"
                    data={[
                        { title: 'Days you\'ve hit your goal', value: this.state.weeklyAdherencePercent, color: '#a7f3d0' },
                        { title: 'Days you have not hit your goal', value: (100-this.state.weeklyAdherencePercent), color: '#fda0a0' },
                    ]}
                    lineWidth={20}
                    animate={true}
                    labelPosition={0}
                    label={() => {return this.state.weeklyAdherencePercent + '%'}}
                />
                <h2 className="text-xl font-bold">{this.state.averageDurationHours} Hours {this.state.averageDurationMinutes} Minutes a day on Average</h2>
                <DailyAdherenceView data={this.state.weeklyAdherence}/>
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

}

export default Homepage;

if (document.getElementById('homepage')) {
    ReactDOM.render(<Homepage />, document.getElementById('homepage'));
}
