import React, {useState, useEffect} from 'react';
import ReactDOM from 'react-dom';
import Overlay from "react-overlay-component";

import accountImage from '../../../images/icons8-account-64.png';
import emailIcon from '../../../images/icons8-email-64.png';
import phoneIcon from '../../../images/icons8-phone-64.png';
import edit from '../../../images/icons8-edit-64.png';

import EditDetailsForm from "./EditDetailsForm";

function ContactSplash() {
    const [contactDetails, setContactDetails] = useState({});
    const [isOpen, setOverlay] = useState(false);

    const closeOverlay = () => setOverlay(false);

    const configs = {
        animate: true,
        clickDismiss: true,
        escapeDismiss: false,
        focusOutline: false,
    };

    useEffect(() => {
        axios.get(`contact-details`)
            .then(r => {
                setContactDetails({
                    name: r.data.name,
                    email: r.data.email,
                    phoneNumber: r.data.phone_number
                })
            })
    }, [])

    return (
        <div className={"text-center"}>
            <div className={"w-11/12 lg:w-max m-2 mt-14 m-auto rounded p-4 shadow-md text-justify bg-white"}>
                <p className={"text-xl text-center"}>Your Local Physiotherapist Contact Details...</p>
                <div className={"m-7"}>
                    <img className="w-14 inline-block" src={accountImage} alt={'Account icon'}/>
                    <p className="card-text">{contactDetails.name}</p>
                </div>
                <div className={"m-7"}>
                    <img className="w-14 inline-block" src={emailIcon} alt={'Email icon'}/>
                    <p className="card-text">{contactDetails.email}</p>
                </div>
                <div className={"m-7"}>
                    <img className="w-14 inline-block" src={phoneIcon} alt={'Phone icon'}/>
                    <p className="card-text">{contactDetails.phoneNumber}</p>
                </div>

            </div>
            <button onClick={() => setOverlay(true)} className={"m-auto mt-5"}>
                <img className="w-14 inline-block" src={edit} alt={"Edit Icon"}/>
                <p className="card-text">Edit these details</p>
            </button>
            <Overlay configs={configs} isOpen={isOpen} closeOverlay={closeOverlay}>
                <EditDetailsForm />
            </Overlay>
        </div>
    );
}

export default ContactSplash;

if (document.getElementById('contact-details')) {
    ReactDOM.render(<ContactSplash/>, document.getElementById('contact-details'));
}
