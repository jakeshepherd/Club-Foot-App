import React from 'react';
import ReactDOM from 'react-dom';

class Settings extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            value: ''
        }
        this.handleChange = this.handleChange.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
    }

    handleChange(event) {
        this.setState({value: event.target.value})
    }

    handleSubmit(event) {
        axios.post(`/set-boots-time-goal`, {
            'time_goal': this.state.value
        }).then(r => alert('Updated your goal time!'))
        event.preventDefault()
    }

    render() {
        return (
            <div className="p-5 m-auto w-10/12 text-center">
                <h1>Settings</h1>
                <form onSubmit={this.handleSubmit}>
                    <input type={"text"} value={this.state.value} onChange={this.handleChange} />
                    <input type={'submit'} value={'Submit'}
                           className="mt-3 m-auto p-2 rounded bg-green-200 inline-block shadow-md transition duration-500 hover:shadow-lg
                                    hover:border-transparent hover:text-white hover:bg-green-500 cursor-pointer" />
                </form>

            </div>
        );
    }
}

export default Settings;

if (document.getElementById('settings')) {
    ReactDOM.render(<Settings />, document.getElementById('settings'));
}
