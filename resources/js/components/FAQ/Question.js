import React from "react";
import {
    Accordion,
    AccordionItem,
    AccordionItemHeading,
    AccordionItemButton,
    AccordionItemPanel,
} from 'react-accessible-accordion';

// Demo styles, see 'Styles' section below for some notes on use.
import 'react-accessible-accordion/dist/fancy-example.css';

function Question(props) {
    return (
        <Accordion allowZeroExpanded className="p-2 w-1/2 m-2 ml-auto mr-auto rounded bg-white shadow-md">
            <AccordionItem>
                <AccordionItemHeading>
                    <AccordionItemButton>
                        <img className="w-9 inline-block" src={props.image} alt={'Skin icon'}/>
                        <p className="ml-4 inline-block text-xl align-middle">{props.name}</p>
                    </AccordionItemButton>
                </AccordionItemHeading>
                <AccordionItemPanel>
                    <h1 className={"text-2xl"}>My child has blisters</h1>
                    <p className="text-gray-500">
                        Blistering is often a sign that the Boots and Bars are not fitting properly!
                        Please call your local practice and we will try and help.
                    </p>
                </AccordionItemPanel>
                <AccordionItemPanel>
                    <h1 className={"text-2xl"}>My child has a rash</h1>
                    <p className="text-gray-500">
                        A rash could mean that there is rubbing on your Boots and Bars,
                        please let us know by calling your local practice.
                    </p>
                </AccordionItemPanel>
            </AccordionItem>
        </Accordion>


        // <div className="p-2 w-1/2 m-2 ml-auto mr-auto rounded bg-white cursor-pointer shadow-md">
        //     <img className="w-9 inline-block" src={props.image} alt={'Skin icon'}/>
        //     <p className="ml-4 inline-block text-xl align-middle">{props.name}</p>
        //     <img className="w-9 mr-6 float-right inline-block" src={dropdown} alt={'Dropdown icon'}/>
        // </div>
    );
}

export default Question;
