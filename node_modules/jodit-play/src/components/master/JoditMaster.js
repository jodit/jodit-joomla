import React, { Component } from 'react';

import Jodit from 'jodit';
// import 'jodit/build/jodit.min.css';


import JoditEditor from "jodit-react";
import style from './style.module.css';
import SyntaxHighlighter, { registerLanguage } from "react-syntax-highlighter/light";
import js from 'react-syntax-highlighter/languages/hljs/javascript';
import { agate as codeStyle} from 'react-syntax-highlighter/styles/hljs';

import Tabs from "../tab/Tabs";
import Tab from "../tab/Tab";
import Options from "./Options";
import Buttons from "./Buttons";
import CheckBox from "../checkbox/CheckBox";
import URL from "../url/URL";
import Text from "../text/Text";
import URLS from "../url/URLS";
import CopyText from "../copytext/CopyText";

registerLanguage('javascript', js);

class JoditMaster extends Component {
    getButtons(type) {
        return Jodit.defaultOptions.buttonsXS.concat(this.getRemoveButtons(type))
    }
    getRemoveButtons(type) {
        return Jodit.defaultOptions.buttons.filter((key) => {
            return key !== '|' && key !== '\n' && Jodit.defaultOptions[type].indexOf(key) === -1
        })
    }
    state = {
        workBoxWidth: 'auto',
        buttons: {
            buttons: Jodit.defaultOptions.buttons,
            buttonsMD: this.getButtons('buttonsMD'),
            buttonsSM: this.getButtons('buttonsSM'),
            buttonsXS: this.getButtons('buttonsXS')
        },
        removeButtons: {
            buttons: [],
            buttonsMD: this.getRemoveButtons('buttonsMD'),
            buttonsSM: this.getRemoveButtons('buttonsSM'),
            buttonsXS: this.getRemoveButtons('buttonsXS'),
        },
        activeIndex: {
            buttons: 0,
            buttonsMD: 0,
            buttonsSM: 0,
            buttonsXS: 0,
        },

        config: {
            autofocus: Jodit.defaultOptions.autofocus,
            toolbar: Jodit.defaultOptions.toolbar,
            iframe: Jodit.defaultOptions.iframe,
            iframeStyle: Jodit.defaultOptions.iframeStyle,

            textIcons: Jodit.defaultOptions.textIcons,
            readonly: Jodit.defaultOptions.readonly,
            spellcheck: Jodit.defaultOptions.spellcheck,
            language: Jodit.defaultOptions.language,
            theme: Jodit.defaultOptions.theme,
            toolbarButtonSize: Jodit.defaultOptions.toolbarButtonSize,
            enter: Jodit.defaultOptions.enter,
            defaultMode: Jodit.defaultOptions.defaultMode,
            allowResizeY: Jodit.defaultOptions.allowResizeY,
            allowResizeX: Jodit.defaultOptions.allowResizeX,

            toolbarAdaptive: Jodit.defaultOptions.toolbarAdaptive,

            height:  Jodit.defaultOptions.height,
            width:  Jodit.defaultOptions.width,
            sizeLG: 800,
            ...this.props.config.initialConfig
        }
    };

    height = 150;
    setHeight = (value) => {
        this.setOption(value === true ? 'auto' : this.height, 'height')
    };
    width = 500;
    setWidth = (value) => {
        this.setOption(value === true ? 'auto' : this.width, 'width')
    };
    setButtons = (name, buttons, removeButtons, activeIndex) => {
        const state = {...this.state};
        let change = false;

        if (this.state.buttons[name] !== buttons) {
            state.buttons[name] = buttons;
            change = true;
        }

        if (this.state.removeButtons[name] !== removeButtons) {
            state.removeButtons[name] = removeButtons;
            change = true;
        }

        if (change) {
            state.config = {...state.config, [name]: buttons.filter((key) => removeButtons.indexOf(key) === -1)}
        }

        if (this.state.activeIndex[name] !== activeIndex) {
            state.activeIndex[name] = activeIndex;
            change = true;
        }

        if (change) {
            this.setState(state);
        }
    };
    timer;
    setOption = (value, name) => {
        clearTimeout(this.timer);
        this.timer = setTimeout(() => {
            switch (name) {
                case 'height':
                case 'width':
                    if (value !== 'auto') {
                        this[name] = value;
                    }
                    break;
                default:
            }

            if (JSON.stringify(this.state[name]) !== JSON.stringify(value)) {
                this.setState(prevState => {
                    let newStage = {...prevState.config};

                    if (name === 'iframe' && value ===  false) {
                        newStage.iframeStyle = Jodit.defaultOptions.iframeStyle;
                        newStage.iframeCSSLinks = Jodit.defaultOptions.iframeCSSLinks;
                        newStage.iframeBaseUrl = Jodit.defaultOptions.iframeBaseUrl;
                    }

                    newStage[name] = value;

                    return {
                    ...prevState,
                        config: newStage
                    }
                });
            }
        }, 100)
    };
    getCode = () => {
        const keys = Object.keys(this.state.config), options= {};
        keys.forEach((key) => {
            if (JSON.stringify(this.state.config[key]) !== JSON.stringify(Jodit.defaultOptions[key]) && ['sizeLG'].indexOf(key) === -1) {
                options[key] = this.state.config[key];
            }
        });

        ['buttons', 'buttonsMD', 'buttonsSM', 'buttonsXS'].forEach((key) => {
            if (options[key]) {
                options[key] = options[key].toString();
            }
        });

        if (typeof this.props.config.setConfig === 'function') {
            this.props.config.setConfig(options);
        }

        const config = JSON.stringify(options, null, 2);
        return 'var editor = new Jodit("#editor"' + (config !== '{}' ? ', '  + config + '' : '') + ');';
    };
    value = '';
    onEditorChange = (value) => {
        this.value = value;
    };
    setWorkboxWidth = (tab) => {
        this.setState({
            ...this.state,
            workBoxWidth: tab.props.width
        });
        setTimeout(() => {
            let event = document.createEvent("HTMLEvents");
            event.initEvent("resize", true, true);
            window.dispatchEvent(event);
        }, 100);
    };

    render() {
        const code = this.getCode();

        if (typeof this.props.config.setCode === 'function') {
            this.props.config.setCode(code);
        }

        return (
            <div className={style.layout}>
                <div className={style.leftside}>
                    {this.props.config.showEditor &&
                    <div>
                        <div className={style.workbox} style={{width: this.state.workBoxWidth}}>
                            <JoditEditor
                                onChange={this.onEditorChange}
                                config={this.state.config}
                                value={this.value}
                            />
                        </div>
                    </div>
                    }
                    {this.props.config.showCode &&
                    <div>
                        <h2>Code</h2>
                        <CopyText>
                            <SyntaxHighlighter showLineNumbers={false} language='javascript'
                                               style={codeStyle}>{code}</SyntaxHighlighter>
                        </CopyText>
                    </div>
                    }
                </div>
                <div className={style.rightside}>
                    <div className={style.item}>
                        <Tabs>
                            <Tab label="Options">
                                <Options
                                    state={this.state.config}
                                    height={this.height}
                                    width={this.width}
                                    setOption={this.setOption}
                                    setHeight={this.setHeight}
                                    setWidth={this.setWidth}
                                />
                            </Tab>
                            {this.props.config.showButtonsTab === false ||
                                this.state.config.toolbar === false ||
                                <Tab label="Buttons">
                                    <CheckBox name="toolbarAdaptive" onChange={this.setOption} defaultChecked={Jodit.defaultOptions.toolbarAdaptive} label="Toolbar adaptive"/>
                                    <Tabs>
                                        <Tab onClick={this.setWorkboxWidth} width={"auto"} label="Desctop">
                                            <Buttons activeIndex={this.state.activeIndex.buttons} removeButtons={this.state.removeButtons.buttons} name="buttons" setButtons={this.setButtons} buttons={this.state.buttons.buttons}/>
                                        </Tab>
                                        {!this.state.config.toolbarAdaptive ||
                                        <Tab onClick={this.setWorkboxWidth} width={799} label="Medium(900px)">
                                            <Buttons activeIndex={this.state.activeIndex.buttonsMD}
                                                     removeButtons={this.state.removeButtons.buttonsMD} name="buttonsMD"
                                                     setButtons={this.setButtons} buttons={this.state.buttons.buttonsMD}/>
                                        </Tab>
                                        }
                                        {!this.state.config.toolbarAdaptive ||
                                        <Tab onClick={this.setWorkboxWidth} width={699} label="Tablet(700px)">
                                            <Buttons activeIndex={this.state.activeIndex.buttonsSM}
                                                     removeButtons={this.state.removeButtons.buttonsSM} name="buttonsSM"
                                                     setButtons={this.setButtons} buttons={this.state.buttons.buttonsSM}/>
                                        </Tab>
                                        }
                                        {!this.state.config.toolbarAdaptive ||
                                        <Tab onClick={this.setWorkboxWidth} width={399} label="Mobile(400px)">
                                            <Buttons activeIndex={this.state.activeIndex.buttonsXS}
                                                     removeButtons={this.state.removeButtons.buttonsXS} name="buttonsXS"
                                                     setButtons={this.setButtons} buttons={this.state.buttons.buttonsXS}/>
                                        </Tab>
                                        }
                                    </Tabs>
                                </Tab>
                            }
                            {this.state.config.iframe === false ||
                            <Tab label="Iframe mode">
                                <URL
                                    label="Iframe Base URL"
                                    name="iframeBaseUrl"
                                    onChange={this.setOption}
                                    value={this.state.config.iframeBaseUrl}
                                />
                                <Text
                                    label="iframe Default Style"
                                    name="iframeStyle"
                                    onChange={this.setOption}
                                    value={this.state.config.iframeStyle}
                                />
                                <URLS
                                    label="Iframe external stylesheets files"
                                    name="iframeCSSLinks"
                                    onChange={this.setOption}
                                    value={this.state.config.iframeCSSLinks}
                                />
                            </Tab>
                            }
                        </Tabs>
                    </div>
                </div>
            </div>
        );
    }
}

export default JoditMaster;
