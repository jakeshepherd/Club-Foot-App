import React from "react";

function EditDetailsForm() {
    return (
        <div className="w-full bg-white md:max-w-sm md:mx-auto">
            <h1 className="block w-full text-center text-gray-600 mb-6">Edit Contact Details</h1>
            <form className="mb-4 md:flex md:flex-wrap md:justify-between" action='/contact-details' method="post">
                <div className="field-group mb-4 md:w-full">
                    <label className="field-label" htmlFor="full_name">Full Name</label>
                    <input className="field" type="text" name="full_name" id="full_name"/>
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
