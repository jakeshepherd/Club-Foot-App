import React from 'react';
import ReactDOM from 'react-dom';
import OutcomeQuestion from "./OutcomeQuestion";

import {toast, ToastContainer} from 'react-toastify';

class QuestionnaireSplash extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            outcome: {}
        }
    }


    render() {
        return (
            <div className="p-5 m-auto w-10/12 text-center">
                <h1>Outcome Questionnaire</h1>
                <OutcomeQuestion />
                <ToastContainer pauseOnFocusLoss draggable/>
            </div>
        );
    }

}

export default QuestionnaireSplash;

if (document.getElementById('outcome-questionnaire')) {
    ReactDOM.render(<QuestionnaireSplash/>, document.getElementById('outcome-questionnaire'));
}
