import React from 'react';
import ReactDOM from 'react-dom';
import TrackingButton from './TrackingButton';
import DailyAdherenceView from './DailyAdherenceView';
import NextCalendarEvent from './NextCalendarEvent';

import {PieChart} from 'react-minimal-pie-chart';
import {toast, ToastContainer} from 'react-toastify';
import ReactTooltip from 'react-tooltip';

class Homepage extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            averageDuration: '',
            weeklyAdherence: {},
            weeklyAdherencePercent: 0,
            elapsedTime: null,
            intervalId: 0,
        }
        this.countUp = this.countUp.bind(this);
        this.startCounting = this.startCounting.bind(this);
        this.stopCounting = this.stopCounting.bind(this);
    }

    async componentDidMount() {
        await axios.get(`/boots-time-goal`)
            .then(r => {
                this.setState({
                    time_goal: r.data/60
                })
            }).catch(() => {
                toast.info('⏰ Please set a time goal by going into your settings in your account.')
            })
        await axios.get(`/get-7-day-average`)
            .then(r => this.setState({
                averageDurationHours: Math.floor(r.data / 60),
                averageDurationMinutes: r.data % 60
            }))
        await axios.get(`/weekly-adherence`)
            .then(r => {
                this.setState({
                    weeklyAdherence: r.data
                })
                const totalSize = Object.keys(this.state.weeklyAdherence).length;
                const numOfTrues = Object.values(this.state.weeklyAdherence).filter(Boolean).length;
                this.setState({
                    weeklyAdherencePercent: Math.round((numOfTrues / totalSize) * 100)
                })
            })
        if (window.sessionStorage.getItem("elapsedTime") !== null) {
            this.setState({
                elapsedTime: parseInt(window.sessionStorage.getItem("elapsedTime"))
            })
        }
    }

    startCounting() {
        let intervalId = setInterval(this.countUp, 1000);
        this.setState({intervalId})
    }

    stopCounting() {
        clearInterval(this.state.intervalId);
        window.sessionStorage.setItem("elapsedTime", this.state.elapsedTime)
    }

    countUp() {
        this.setState(({ elapsedTime }) => ({ elapsedTime: elapsedTime + 1 }));
        window.sessionStorage.setItem("elapsedTime", this.state.elapsedTime)
    }

    render() {
        return (
            <div className="p-5 m-auto w-10/12 text-center">
                <h2 className="font-seoulNamsan text-xl font-bold">Your Boots and Bars use over the last 7 days</h2>
                <PieChart
                    className="m-auto mt-4 mb-4 w-1/2 md:w-56"
                    data={[
                        {
                            title: 'Time elapsed',
                            value: this.state.elapsedTime,
                            color: '#a7f3d0'
                        },
                        {
                            value: (360),
                            color: '#fda0a0'
                        },
                    ]}
                    lineWidth={20}
                    animate={true}
                    labelPosition={0}
                    label={() => {
                        if (this.state.elapsedTime === null) {
                            return '0s'
                        }
                        return this.state.elapsedTime + 's'
                    }}
                />
                <h2 className="text-xl font-bold">{this.state.averageDurationHours} hours {this.state.averageDurationMinutes} minutes
                    a day on average</h2>
                <DailyAdherenceView data={this.state.weeklyAdherence}/>
                <TrackingButton startCounting={this.startCounting} stopCounting={this.stopCounting}/>
                <h2 className="mt-5 text-xl font-bold">What's Coming up...</h2>
                <NextCalendarEvent
                    eventDetails={{
                        eventName: 'Meet With Physio',
                        eventDate: '24th Dec',
                        eventTime: '4pm',
                    }}
                />
                <ToastContainer pauseOnFocusLoss draggable hideProgressBar/>
                <ReactTooltip />
            </div>
        );
    }

}

export default Homepage;

if (document.getElementById('homepage')) {
    ReactDOM.render(<Homepage/>, document.getElementById('homepage'));
}
