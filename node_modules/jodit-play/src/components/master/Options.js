import React, { Component } from 'react';
import Jodit from "jodit";
import List from "../list/List";
import Number from "../number/Number";
import CheckBox from "../checkbox/CheckBox";



export default class Options extends Component {
    render() {
        return (
            <div>
                <CheckBox name="autofocus" onChange={this.props.setOption} defaultChecked={this.props.state.autofocus} label="Autofocus"/>
                <CheckBox name="toolbar" onChange={this.props.setOption} defaultChecked={this.props.state.toolbar} label="Show Toolbar"/>
                {this.props.state.toolbar === false ||
                <CheckBox
                    name="textIcons"
                    onChange={this.props.setOption}
                    defaultChecked={this.props.textIcons}
                    label="Text Icons"
                />
                }
                <CheckBox name="readonly" onChange={this.props.setOption} defaultChecked={this.props.state.readonly} label="Read Only"/>

                <CheckBox name="spellcheck" onChange={this.props.setOption} defaultChecked={this.props.state.spellcheck} label="Spell Check"/>

                <List value={this.props.state.language} name="language" onChange={this.props.setOption} list={['Auto', ...Object.keys(Jodit.lang)]} label="Language"/>

                <List value={this.props.state.theme} name="theme" onChange={this.props.setOption} list={{
                    'default' : 'Default',
                    'dark' : 'Dark',
                }} label="Theme"/>
                {this.props.state.toolbar === false ||
                <List value={this.props.state.toolbarButtonSize} name="toolbarButtonSize"
                      onChange={this.props.setOption} list={[
                    "small", "middle", "large"
                ]} label="Size of icons"/>
                }
                <List name="enter" value={this.props.state.enter} onChange={this.props.setOption} list={{
                    "P": 'Paragraph (P)',
                    "DIV": 'Block (DIV)',
                    "BR": 'Break (BR)',
                }} label="Element that will be created on Enter"/>


                <List name="defaultMode" value={this.props.state.defaultMode} onChange={this.props.setOption} list={{
                    [Jodit.MODE_WYSIWYG]: 'WYSIWYG',
                    [Jodit.MODE_SOURCE]: 'Source code',
                    [Jodit.MODE_SPLIT]: 'Split code',
                }} label="Default mode"/>

                {this.props.state.height === 'auto' ||
                <CheckBox right name="allowResizeY" onChange={this.props.setOption} defaultChecked={this.props.state.allowResizeY} label="Allow Height resize"/>
                }
                <CheckBox name="height" onChange={this.props.setHeight} defaultChecked={this.props.state.height === 'auto'} label="Auto height"/>

                {this.props.state.height === 'auto' ||
                <Number
                    label="Height in pixels"
                    name="height"
                    onChange={this.props.setOption}
                    value={this.props.state.height}
                />
                }
                {this.props.state.width === 'auto' ||
                <CheckBox right name="allowResizeX" onChange={this.props.setOption} defaultChecked={this.props.state.allowResizeX} label="Allow Width resize"/>
                }
                <CheckBox name="width" onChange={this.props.setWidth} defaultChecked={this.props.state.width === 'auto'} label="Auto width"/>

                {this.props.state.width !== 'auto' ?
                    <Number
                        label="Width in pixels"
                        name="width"
                        onChange={this.props.setOption}
                        value={this.props.state.width}
                    /> : ''
                }

                <CheckBox name="iframe" onChange={this.props.setOption} defaultChecked={this.props.state.iframe} label="Iframe mode"/>

            </div>
        );
    }
}