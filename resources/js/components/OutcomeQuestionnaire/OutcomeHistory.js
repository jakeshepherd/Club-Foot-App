import React from "react";
import ReactDOM from "react-dom";

class OutcomeHistory extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            results: {}
        }
    }

    componentDidMount() {
        axios.get(`/outcome-results`)
            .then(r => this.setState({
                results: r.data
            }))
    }

    render() {
        return (
            <div className={"text-center mt-4"}>
                <h1 className={"text-xl font-bold"}>Questionnaire results from the past</h1>
                <div className={"grid grid-cols-2"}>
                    {Object.entries(this.state.results).map(([key, value]) => {
                        let result = value.replace('[', '').replace(']', '').split(',')
                        return (
                            <div className={"mt-4 p-4 bg-white w-1/2 rounded shadow-md ml-auto mr-auto"} key={key}>
                                <p className={"font-bold"}>On {key}: </p>
                                <p>Q1: {result[0]}</p>
                                <p>Q2: {result[1]}</p>
                                <p>Q3: {result[2]}</p>
                                <p>Q4: {result[3]}</p>
                                <p>Q5: {result[4]}</p>
                                <p>Q6: {result[5]}</p>
                                <p>Q7: {result[6]}</p>
                                <p>Q8: {result[7]}</p>
                                <p>Q9: {result[8]}</p>
                                <p>Q10: {result[9]}</p>
                            </div>
                        )
                    })}
                </div>
            </div>
        );
    }
}

export default OutcomeHistory;

if (document.getElementById('outcome-history')) {
    ReactDOM.render(<OutcomeHistory/>, document.getElementById('outcome-history'));
}
