import React from "react";

function EditDetailsForm() {
    return (
        <div className="w-full bg-white md:max-w-sm md:mx-auto">
            <h1 className="block w-full text-center text-gray-600 mb-6">Edit Contact Details</h1>
            <form className="mb-4 md:flex md:flex-wrap md:justify-between" action="/" method="post">
                <div className="field-group mb-4 md:w-1/2">
                    <label className="field-label" htmlFor="first_name">First Name</label>
                    <input className="field md:mr-2" type="text" name="first_name" id="first_name"/>
                </div>
                <div className="field-group mb-4 md:w-1/2">
                    <label className="field-label md:ml-2" htmlFor="last_name">Last Name</label>
                    <input className="field md:ml-2" type="text" name="last_name" id="last_name"/>
                </div>
                <div className="field-group mb-4 md:w-full">
                    <label className="field-label" htmlFor="email">Email</label>
                    <input className="field" type="email" name="email" id="email"/>
                </div>
                <div className="field-group mb-4 md:w-full">
                    <label className="field-label" htmlFor="phone_number">Phone Number</label>
                    <input className="field" type="tel" name="phone_number" id="phone_number"/>
                </div>
                <button className="btn btn-teal mx-auto" type="submit">Submit</button>
            </form>
        </div>
    )
}

export default EditDetailsForm;
