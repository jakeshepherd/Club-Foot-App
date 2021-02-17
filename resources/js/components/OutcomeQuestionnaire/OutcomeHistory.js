import React from "react";
import ReactDOM from "react-dom";

class OutcomeHistory extends React.Component {
    render() {
        return (
            <div>
                hey
            </div>
        );
    }
}

export default OutcomeHistory;

if (document.getElementById('outcome-history')) {
    ReactDOM.render(<OutcomeHistory/>, document.getElementById('outcome-history'));
}
