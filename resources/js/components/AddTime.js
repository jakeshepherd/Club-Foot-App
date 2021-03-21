import React from "react";
import {toast, ToastContainer} from "react-toastify";
import DatePicker from "react-datepicker";

import "react-datepicker/dist/react-datepicker.css";

class AddTime extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            hours: '',
            date: new Date(),
            error: false
        }
    }

    handleNameChange(event) {
        this.setState({date: event.target.value})
    }

    handleHoursChange(event) {
        const regex = /^[0-9\b]+$/;
        if (regex.test(event.target.value)) {
            this.setState({hours: event.target.value})
        }
    }

    handleSubmit(event) {
        if (this.state.date === '' || this.state.hours === '') {
            this.setState({
                error: true
            })
        } else {
            axios.post(`/set-time`, {
                'end_time': this.state.date,
                'duration': this.state.hours*60,
            }).then(() => {
                toast.success('✅ Boots and Bars Hours Added')
                window.location.reload(false);
            })
        }
        event.preventDefault()
    }

    render() {
        return (
            <div className="w-full bg-white md:max-w-sm md:mx-auto">
                <h1 className="block w-full text-center text-gray-600 mb-6">Add Boots and Bars Time</h1>
                <form className="mb-4 md:flex md:flex-wrap md:justify-between"
                      onSubmit={(event) => this.handleSubmit(event)}>
                    <div className="field-group mb-4 md:w-full">
                        <label className="field-label" htmlFor="date">Select Date</label>
                        <DatePicker className="shadow-xl rounded border-transparent" selected={this.state.date} onChange={date => this.setState({date:date})} dateFormat={"d-MM-yyyy"}/>
                    </div>
                    <div className="field-group mb-4 md:w-full">
                        <label className="field-label" htmlFor="hours_worn">Time worn for (hours)</label>
                        <input className="shadow-xl py-2 px-3 rounded border-transparent" type="integer" name="hours_worn" id="hours_worn"
                               value={this.state.hours} onChange={(event) => this.handleHoursChange(event)}/>
                    </div>
                    <button className="btn btn-teal mx-auto" type="submit">Submit</button>
                </form>
                {this.state.error && <p className={"text-red-600 mt-4"}>Please Fill in all the Details</p>}
                <ToastContainer draggable/>
            </div>
        )
    }
}

export default AddTime
