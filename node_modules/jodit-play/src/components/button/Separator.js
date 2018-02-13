import React, { Component } from 'react';
import style from './style.module.css';

export default class Separator extends Component {
    remove = (e) => {
        this.props.remove(this.props.index);
        e.stopPropagation()
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
        return <tr onDoubleClick={this.setActive} className={style.row + ' ' + style.separator + ' ' + (this.props.active ? style.row_active : '')}>
            <td colSpan={2}>
               Group separator
            </td>
            <td>
                <span onClick={this.moveUp} className={style.moveUp}></span>
                <span onClick={this.moveDown} className={style.moveDown}></span>
            </td>
            <td className={style.lastCol}>
                <span onClick={this.remove} className={style.trash}></span>
            </td>
        </tr>;
    }
}