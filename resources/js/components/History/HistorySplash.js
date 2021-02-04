import React from "react";
import ReactDOM from "react-dom";

class HistorySplash extends React.Component {
    render() {
        return (
            <div className={"text-center"}>
                Your progress so far!
            </div>
        );
    }
}
export default HistorySplash;

if (document.getElementById('history')) {
    ReactDOM.render(<HistorySplash/>, document.getElementById('history'));
}
