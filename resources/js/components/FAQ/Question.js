import React from "react";

import skin from '../../../images/icons8-skin-80.png';

function Question() {
    return (
        <div className="w-max p-2 ml-auto mr-auto mt-2 rounded bg-white cursor-pointer shadow-md">
            <img src={skin}  alt={'Skin icon'}/>
            <p>Skin Issues</p>
        </div>
    );
}

export default Question;
