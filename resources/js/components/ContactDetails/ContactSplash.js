import React from 'react';
import ReactDOM from 'react-dom';

import accountImage from '../../../images/icons8-account-64.png';
import emailIcon from '../../../images/icons8-email-64.png';
import phoneIcon from '../../../images/icons8-phone-64.png';

class ContactSplash extends React.Component {
    render() {
        return (
            <div className={"w-max m-2 mt-14 m-auto rounded p-4 shadow-md text-justify"}>
                <p className={"text-xl text-center"}>Your Local Physiotherapist Contact Details...</p>
                <div className={"m-7"}>
                    <img className="w-14 inline-block" src={accountImage} alt={'Account icon'}/>
                    <p className="card-text">Dr. Example</p>
                </div>
                <div className={"m-7"}>
                    <img className="w-14 inline-block" src={emailIcon} alt={'Email icon'}/>
                    <p className="card-text">doctor@example.com</p>
                </div>
                <div className={"m-7"}>
                    <img className="w-14 inline-block" src={phoneIcon} alt={'Phone icon'}/>
                    <p className="card-text">0123456789</p>
                </div>
            </div>
        );
    }
}

export default ContactSplash;

if (document.getElementById('contact-details')) {
    ReactDOM.render(<ContactSplash/>, document.getElementById('contact-details'));
}
