import React from "react";

class OutcomeQuestion extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            one: false,
            two: false,
            three: false,
            four: false,
            selectedAnswer: 0,
        }
    }

    selectAnswer(answerId) {
        // set everything to false as we can only have 1 answer selected
        this.setState({
            one: false,
            two: false,
            three: false,
            four: false,
            [answerId]: !this.state.[answerId],
            selectedAnswer: [answerId],
        })
        this.props.handleQuestionSubmit(this.props.questionNumber, this.state.selectedAnswer)
    }

    render() {
        const oneColour = this.state.one ? 'green-500' : 'white';
        const twoColour = this.state.two ? 'green-500' : 'white';
        const threeColour = this.state.three ? 'green-500' : 'white';
        const fourColour = this.state.four ? 'green-500' : 'white';

        return (
            <div className={"w-11/12 lg:w-1/2 m-2 mt-14 m-auto rounded p-4 shadow-md text-center bg-blue-100"}>
                <h1>{this.props.question}</h1>
                <div className={"grid grid-cols-2"}>
                    <p className={"shadow-md rounded p-2 m-2 w-24 justify-self-center cursor-pointer transition duration-500 bg-" + oneColour}
                       onClick={() => this.selectAnswer('one')}>{this.props.answers.one}</p>
                    <p className={"shadow-md rounded p-2 m-2 w-24 justify-self-center cursor-pointer transition duration-500 bg-" + twoColour}
                       onClick={() => this.selectAnswer('two')}>{this.props.answers.two}</p>
                    <p className={"shadow-md rounded p-2 m-2 w-24 justify-self-center cursor-pointer transition duration-500 bg-" + threeColour}
                       onClick={() => this.selectAnswer('three')}>{this.props.answers.three}</p>
                    <p className={"shadow-md rounded p-2 m-2 w-24 justify-self-center cursor-pointer transition duration-500 bg-" + fourColour}
                       onClick={() => this.selectAnswer('four')}>{this.props.answers.four}</p>
                </div>
            </div>
        )
    }
}

export default OutcomeQuestion;
