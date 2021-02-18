import React from "react";
import {
    Accordion,
    AccordionItem,
    AccordionItemHeading,
    AccordionItemButton,
    AccordionItemPanel,
} from 'react-accessible-accordion';
import 'react-accessible-accordion/dist/fancy-example.css';

class Question extends React.Component {
    render() {
        return (
            <Accordion allowZeroExpanded className="w-4/5 md:w-1/2 m-2 ml-auto mr-auto rounded bg-white shadow-md">
                <AccordionItem>
                    <AccordionItemHeading>
                        <AccordionItemButton>
                            <img className="w-9 inline-block" src={this.props.image} alt={this.props.name + ' icon'}/>
                            <p className="card-text text-xl">{this.props.name}</p>
                        </AccordionItemButton>
                    </AccordionItemHeading>
                    {this.props.FAQs.map((subQuestion, value) => (
                        <AccordionItemPanel key={value}>
                            <h1 className={"text-2xl"}>{subQuestion.question}</h1>
                            <p className="text-gray-500">
                                {subQuestion.answer}
                            </p>
                        </AccordionItemPanel>
                    ))}
                </AccordionItem>
            </Accordion>
        );
    }
}

export default Question;
