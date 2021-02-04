import React from "react";
import {toast, ToastContainer} from "react-toastify";

class EditDetailsForm extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            name: '',
            email: '',
            phoneNumber: '',
            error: false
        }
    }

    handleNameChange(event) {
        this.setState({name: event.target.value})
    }

    handleEmailChange(event) {
        this.setState({email: event.target.value})
    }

    handlePhoneChange(event) {
        this.setState({phoneNumber: event.target.value})
    }

    handleSubmit(event) {
        if (this.state.name === '' || this.state.email === '' || this.state.phoneNumber === '') {
            this.setState({
                error: true
            })
        } else {
            axios.post(`/contact-details`, {
                'name': this.state.name,
                'email': this.state.email,
                'phone_number': this.state.phoneNumber,
            }).then(() => {
                toast.success('✅ Contact Details Updated')
                window.location.reload(false);
            })
        }
        event.preventDefault()
    }

    render() {
        return (
            <div className="w-full bg-white md:max-w-sm md:mx-auto">
                <h1 className="block w-full text-center text-gray-600 mb-6">Edit Contact Details</h1>
                <form className="mb-4 md:flex md:flex-wrap md:justify-between" onSubmit={(event) => this.handleSubmit(event)}>
                    <div className="field-group mb-4 md:w-full">
                        <label className="field-label" htmlFor="full_name">Full Name</label>
                        <input className="field" type="text" name="full_name" id="full_name"
                               value={this.state.name} onChange={(event) => this.handleNameChange(event)}/>
                    </div>
                    <div className="field-group mb-4 md:w-full">
                        <label className="field-label" htmlFor="email">Email</label>
                        <input className="field" type="email" name="email" id="email"
                               value={this.state.email} onChange={(event) => this.handleEmailChange(event)}/>
                    </div>
                    <div className="field-group mb-4 md:w-full">
                        <label className="field-label" htmlFor="phone_number">Phone Number</label>
                        <input className="field" type="tel" name="phone_number" id="phone_number"
                               value={this.state.phoneNumber} onChange={(event) => this.handlePhoneChange(event)}/>
                    </div>
                    <button className="btn btn-teal mx-auto" type="submit">Submit</button>
                    {this.state.error && <p className={"text-red-600"}>Please Fill in all the Details</p>}
                </form>
                <ToastContainer draggable/>
            </div>
        )
    }
}

export default EditDetailsForm;
