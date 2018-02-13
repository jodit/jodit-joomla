import React, { Component } from 'react';
import style from './style.module.css';
import CheckBox from "../checkbox/CheckBox";
import Jodit from "jodit";


export default class Button extends Component {
    toggle = (active) => {
        this.props.toggle(this.props.index, active);
    };
    setActive = () => {
        this.props.setActive(this.props.index);
    };
    moveUp = () => {
        this.props.move(this.props.index, true)
    };
    moveDown = () => {
        this.props.move(this.props.index, false)
    };
    render() {
        return <tr onDoubleClick={this.setActive} className={style.row + ' ' + (this.props.active ? style.row_active : '')+ ' ' + (!this.props.checked ? style.row_disable : '')}>
            <td>
                <div className={style.icon} dangerouslySetInnerHTML={{__html:Jodit.modules.ToolbarIcon.getIcon(this.props.label)}}/>
            </td>
            <td>
                {this.props.label}
            </td>
            <td>
                <span onClick={this.moveUp} className={style.moveUp}></span>
                <span onClick={this.moveDown} className={style.moveDown}></span>
            </td>
            <td  className={style.lastCol}>
                <CheckBox checked={this.props.checked} onChange={this.toggle}/>
            </td>
        </tr>;
    }
}