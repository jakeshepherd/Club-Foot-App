import React from 'react';
import ReactDOM from 'react-dom';
import TrackingButton from './TrackingButton';
import DailyAdherenceView from './DailyAdherenceView';
import NextCalendarEvent from './NextCalendarEvent';
import Overlay from "react-overlay-component";
import AddTime from "./AddTime";

import addEvent from '../../images/icons8-add-property.svg';

import {toast, ToastContainer} from 'react-toastify';
import ReactTooltip from 'react-tooltip';
import moment from 'moment';
import {buildStyles, CircularProgressbar} from 'react-circular-progressbar';
import 'react-circular-progressbar/dist/styles.css';


const configs = {
    animate: true,
    clickDismiss: true,
    escapeDismiss: false,
    focusOutline: false,
};

class Homepage extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            averageDuration: '',
            weeklyAdherence: {},
            weeklyAdherencePercent: 0,
            elapsedTimeSecs: 0,
            elapsedTimeMins: 0,
            elapsedTimeHours: 0,
            intervalIdSecs: 0,
            trackingState: 'tracking',
            isOpen: false,
        }
        this.countUpSecs = this.countUpSecs.bind(this);
        this.startCounting = this.startCounting.bind(this);
        this.stopCounting = this.stopCounting.bind(this);
        this.closeOverlay = this.closeOverlay.bind(this)
    }

    closeOverlay () {
        this.setState({isOpen: false});
    }

    async componentDidMount() {
        await axios.get(`/boots-time-goal`)
            .then(r => {
                this.setState({
                    time_goal: r.data / 60
                })
            }).catch(() => {
                toast.info('⏰ Please set a time goal by going into your settings in the top right.')
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

        if (this.state.trackingState === 'tracking') {
            const endTime = moment(new Date())
            const diffDuration = moment.duration(
                endTime.diff(moment(window.localStorage.getItem("startTime")))
            )
            this.setState({
                elapsedTimeMins: diffDuration.minutes(),
                elapsedTimeSecs: Math.round(diffDuration / 1000),
                elapsedTimeHours: diffDuration.hours(),
            })
        } else if (this.state.trackingState === 'stopped') {
            this.setState({
                elapsedTime: 0
            })
        } else if (this.state.trackingState === 'paused') {

        }
    }

    startCounting(trackingState, startTime) {
        this.setState({
            trackingState: trackingState,
        })

        window.localStorage.setItem("startTime", startTime)

        let intervalIdSecs = setInterval(this.countUpSecs, 1000);
        this.setState({intervalIdSecs})
    }

    stopCounting(trackingState) {
        this.setState({
            trackingState: trackingState,
            elapsedTimeSecs: 0,
            elapsedTimeMins: 0,
            elapsedTimeHours: 0,
        })
        clearInterval(this.state.intervalIdSecs);
        window.localStorage.removeItem("elapsedTime");
        window.localStorage.removeItem("startTime");
    }

    pauseCounting() {
        clearInterval(this.state.intervalIdSecs);
        window.localStorage.setItem("elapsedTime", this.state.elapsedTimeSecs)
    }

    countUpSecs() {
        this.setState(({elapsedTimeSecs}) => ({elapsedTimeSecs: elapsedTimeSecs + 1}));
        if (this.state.elapsedTimeSecs % 60 === 0) {
            this.setState(({elapsedTimeMins}) => ({elapsedTimeMins: elapsedTimeMins + 1}));
        }
        if (this.state.elapsedTimeMins % 60 === 0 && this.state.elapsedTimeMins !== 0) {
            this.setState(({elapsedTimeHours}) => ({elapsedTimeHours: elapsedTimeHours + 1}));
        }
        window.localStorage.setItem("elapsedTime", this.state.elapsedTimeSecs)
    }

    render() {
        return (
            <div className="p-5 m-auto w-10/12 text-center">
                <h2 className="font-seoulNamsan text-xl font-bold">Your Boots and Bars time for your current session</h2>
                <div className={"m-auto mt-4 mb-4 w-1/2 md:w-56"}>
                    <CircularProgressbar
                        styles={buildStyles({
                            // Rotation of path and trail, in number of turns (0-1)

                            // Whether to use rounded or flat corners on the ends - can use 'butt' or 'round'
                            strokeLinecap: 'round',

                            // Text size
                            textSize: '16px',

                            // How long animation takes to go from one percentage to another, in seconds
                            pathTransitionDuration: 0.2,

                            // Can specify path transition in more detail, or remove it entirely
                            // pathTransition: 'none',

                            // Colors
                            pathColor: '#a7f3d0',
                            textColor: 'black',
                            trailColor: '#fda0a0',
                        })}

                        value={this.state.elapsedTimeSecs}
                        maxValue={this.state.time_goal * 60 * 60}
                        text={this.state.elapsedTimeHours + 'h ' + this.state.elapsedTimeMins + 'm ' + (this.state.elapsedTimeSecs % 60) + 's'}
                    />
                </div>
                <h2 className="text-xl font-bold">{this.state.averageDurationHours} hours {this.state.averageDurationMinutes} minutes
                    a day on average</h2>
                <DailyAdherenceView data={this.state.weeklyAdherence}/>
                <div>
                    <TrackingButton className={"inline"} startCounting={this.startCounting} stopCounting={this.stopCounting}/>
                    <img data-tip={"Add boots and bars time retrospectively here"}
                         src={addEvent}
                         alt={"Add event"}
                         className={"inline w-10 cursor-pointer align-middle ml-4"}
                         onClick={() => this.setState({isOpen: true})}
                    />
                </div>
                <h2 className="mt-5 text-xl font-bold">What's Coming up...</h2>
                <NextCalendarEvent
                    eventDetails={{
                        eventName: 'Meet With Physio',
                        eventDate: '24th Dec',
                        eventTime: '4pm',
                    }}
                />
                <Overlay configs={configs} isOpen={this.state.isOpen} closeOverlay={this.closeOverlay}>
                    <AddTime />
                </Overlay>
                <ToastContainer pauseOnFocusLoss draggable hideProgressBar/>
                <ReactTooltip multiline={true}/>
            </div>
        );
    }

}

export default Homepage;

if (document.getElementById('homepage')) {
    ReactDOM.render(<Homepage/>, document.getElementById('homepage'));
}
