import React from "react";
import { makeStyles, useTheme } from '@material-ui/core/styles';
import AppBar from '@material-ui/core/AppBar';
import Toolbar from '@material-ui/core/Toolbar';
import IconButton from '@material-ui/core/IconButton';
import MenuIcon from '@material-ui/icons/Menu';
import Typography from '@material-ui/core/Typography';
import Drawer from '@material-ui/core/Drawer';
import List from '@material-ui/core/List';
import ListItem from '@material-ui/core/ListItem';
import ListItemIcon from '@material-ui/core/ListItemIcon';
import ListItemText from '@material-ui/core/ListItemText';
import ListIcon from '@material-ui/icons/List';
import SyncAltIcon from '@material-ui/icons/SyncAlt';
import DeleteIcon from '@material-ui/icons/Delete';
import ChevronLeftIcon from '@material-ui/icons/ChevronLeft';
import Divider from '@material-ui/core/Divider';
import { Link } from 'react-router-dom';

const useStyles = makeStyles((theme) => ({
    drawerHeader: {
        display: 'flex',
        alignItems: 'center',
        padding: theme.spacing(0, 1),
        ...theme.mixins.toolbar,
        justifyContent: 'flex-end',
    }
}))


export class NavBar extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            open: false,
        };
    }

    handleDrawerOpen = () => {
        this.setState({
            open: true
        })
    }

    handleDrawerClose = () => {
        this.setState({
            open: false
        })
    }

    render() {
        let open = this.state.open;
        return (<div>
            <AppBar position="static">
                <Toolbar>
                    <IconButton
                        aria-label="open drawer"
                        onClick={this.handleDrawerOpen}
                        edge="start">
                        <MenuIcon />
                    </IconButton>
                    <Typography variant="h6" noWrap>
                        Список студентов факультета
                    </Typography>
                </Toolbar>
            </AppBar>

            <Drawer
                variant="persistent"
                anchor="left"
                open={open}
            >
                <div className={useStyles.drawerHeader}>
                    <IconButton onClick={this.handleDrawerClose}>
                        <ChevronLeftIcon />
                    </IconButton>
                </div>
                <Divider />

                <List>
                    <Link to='/'>
                        <ListItem button key={'seeStud'} onClick={this.handleDrawerClose}>
                            <ListItemIcon><ListIcon /></ListItemIcon>
                            <ListItemText primary={'Посмотреть список студентов'} />
                        </ListItem>
                    </Link>

                    <Link to='/transfer'>
                        <ListItem button key={'transferStud'} onClick={this.handleDrawerClose}>
                            <ListItemIcon><SyncAltIcon /></ListItemIcon>
                            <ListItemText primary={'Перевести студентов'} />
                        </ListItem>
                    </Link>

                    <Link to='/exclude'>
                        <ListItem button key={'excludeStud'} onClick={this.handleDrawerClose}>
                            <ListItemIcon><DeleteIcon /></ListItemIcon>
                            <ListItemText primary={'Отчислить студентов'} />
                        </ListItem>
                    </Link>

                </List>

            </Drawer>
        </div>)
    }
}