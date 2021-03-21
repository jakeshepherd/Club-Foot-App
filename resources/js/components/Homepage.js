import React from 'react';
import ReactDOM from 'react-dom';
import TrackingButton from './TrackingButton';
import DailyAdherenceView from './DailyAdherenceView';
import NextCalendarEvent from './NextCalendarEvent';
import Overlay from "react-overlay-component";

import addEvent from '../../images/icons8-add-property.svg';

import {PieChart} from 'react-minimal-pie-chart';
import {toast, ToastContainer} from 'react-toastify';
import ReactTooltip from 'react-tooltip';
import EditDetailsForm from "./ContactDetails/EditDetailsForm";
import AddTime from "./AddTime";

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
            isOpen: false,
        }
        this.closeOverlay = this.closeOverlay.bind(this)
    }

    closeOverlay () {
        this.setState({isOpen: false});
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
    }

    render() {
        return (
            <div className="p-5 m-auto w-10/12 text-center">
                <h2 className="font-seoulNamsan text-xl font-bold">Your Boots and Bars use over the last 7 days</h2>
                <PieChart
                    className="m-auto mt-4 mb-4 w-1/2 md:w-56"
                    data={[
                        {
                            title: 'Days you\'ve hit your goal',
                            value: this.state.weeklyAdherencePercent,
                            color: '#a7f3d0'
                        },
                        {
                            title: 'Days you have not hit your goal',
                            value: (100 - this.state.weeklyAdherencePercent),
                            color: '#fda0a0'
                        },
                    ]}
                    lineWidth={20}
                    animate={true}
                    labelPosition={0}
                    label={() => {
                        return this.state.weeklyAdherencePercent + '%'
                    }}
                />
                <h2 className="text-xl font-bold">{this.state.averageDurationHours} hours {this.state.averageDurationMinutes} minutes
                    a day on average</h2>
                <DailyAdherenceView data={this.state.weeklyAdherence}/>
                <div>
                    <TrackingButton className={"inline"}/>
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
                <ReactTooltip />
            </div>
        );
    }

}

export default Homepage;

if (document.getElementById('homepage')) {
    ReactDOM.render(<Homepage/>, document.getElementById('homepage'));
}
