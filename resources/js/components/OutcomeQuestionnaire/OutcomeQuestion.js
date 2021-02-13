import React from "react";

class OutcomeQuestion extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            one: false,
            two: false,
            three: false,
            four: false
        }
    }

    selectAnswer(answerId) {
        // set everything to false as we can only have 1 answer selected
        this.setState({
            one: false,
            two: false,
            three: false,
            four: false,
            [answerId]: !this.state.[answerId]
        })
    }

    render() {
        const oneColour = this.state.one ? 'green-500' : 'white';
        const twoColour = this.state.two ? 'green-500' : 'white';
        const threeColour = this.state.three ? 'green-500' : 'white';
        const fourColour = this.state.four ? 'green-500' : 'white';

        return (
            <div className={"w-11/12 lg:w-max m-2 mt-14 m-auto rounded p-4 shadow-md text-center bg-blue-100"}>
                <h1>How satisfied are you with the status of your child's foot?</h1>
                <div className={"grid grid-cols-2"}>
                    <p className={"shadow-md rounded p-2 m-2 w-24 justify-self-center cursor-pointer transition duration-500 bg-" + oneColour}
                       onClick={() => this.selectAnswer('one')}>Very Satisfied</p>
                    <p className={"shadow-md rounded p-2 m-2 w-24 justify-self-center cursor-pointer transition duration-500 bg-" + twoColour}
                       onClick={() => this.selectAnswer('two')}>Somewhat Satisfied</p>
                    <p className={"shadow-md rounded p-2 m-2 w-24 justify-self-center cursor-pointer transition duration-500 bg-" + threeColour}
                       onClick={() => this.selectAnswer('three')}>Somewhat Dissatisfied</p>
                    <p className={"shadow-md rounded p-2 m-2 w-24 justify-self-center cursor-pointer transition duration-500 bg-" + fourColour}
                       onClick={() => this.selectAnswer('four')}>Very Dissatisfied</p>
                </div>
                <button className={"button rounded-full p-2 w-24 bg-blue-400 hover:bg-blue-500"}>Next</button>
            </div>
        )
    }
}

export default OutcomeQuestion;
