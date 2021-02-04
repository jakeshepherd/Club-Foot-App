import React from 'react';
import ReactDOM from 'react-dom';

import {toast, ToastContainer} from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';

class Settings extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            value: ''
        }
    }

    async componentDidMount() {
        await axios.get(`/boots-time-goal`)
            .then(r => this.setState({
                value: (r.data/60).toFixed(1)
            }))
    }

    handleChange(event) {
        this.setState({value: event.target.value})
    }

    handleSubmit(event) {
        if (this.state.value === '') {
            toast.error('Please add a goal time')
        } else {
            axios.post(`/boots-time-goal`, {
                'time_goal': this.state.value
            }).then(r => toast.success('🕒 Updated your goal time!'))
        }
        event.preventDefault()
    }

    render() {
        return (
            <div className="p-5 m-auto w-10/12 text-center">
                <h1 className="text-2xl">Settings</h1>
                <form onSubmit={(event) => this.handleSubmit(event)}>
                    <label className="">
                        Boots and Bars Time Goal
                        <br />
                        <input className="rounded w-max m-2 text-center bg-gray-200 border-gray-200 transition duration-500 hover:shadow-md"
                               type={"text"} value={this.state.value} onChange={(event) => this.handleChange(event)} />
                        Hours
                    </label>
                    <br />
                    <input type={'submit'} value={'Submit'} className="button mt-3 p-2 bg-green-200 hover:bg-green-500" />
                </form>
                <ToastContainer pauseOnFocusLoss draggable/>
            </div>
        );
    }
}

export default Settings;

if (document.getElementById('settings')) {
    ReactDOM.render(<Settings />, document.getElementById('settings'));
}
