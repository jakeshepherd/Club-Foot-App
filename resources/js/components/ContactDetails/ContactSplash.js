import React from 'react';
import ReactDOM from 'react-dom';

class ContactSplash extends React.Component {
    render() {
        return (
            <div>
                Contact Details
            </div>
        );
    }
}

export default ContactSplash;

if (document.getElementById('contact-details')) {
    ReactDOM.render(<ContactSplash/>, document.getElementById('contact-details'));
}
