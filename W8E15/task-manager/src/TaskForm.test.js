import React from 'react';
import { render, screen, fireEvent } from '@testing-library/react';
import TaskForm from './TaskForm';
import {TasksContext} from "./TaskManager";

test('renders TaskForm with the required fields and buttons', () => {
    const mockContext = {
        saveTask: jest.fn(),
        editTask: null,
        setShowForm: jest.fn(),
    };

    render(
        <TasksContext.Provider value={mockContext}>
            <TaskForm />
        </TasksContext.Provider>
    );

    expect(screen.getByLabelText(/Task Name/i)).toBeInTheDocument();
    expect(screen.getByLabelText(/Task Description/i)).toBeInTheDocument();
    expect(screen.getByRole('button', { name: /Add Task/i })).toBeInTheDocument();
    expect(screen.getByRole('button', { name: /Cancel/i })).toBeInTheDocument();
});

test('updates the input fields on change', () => {
    const mockContext = {
        saveTask: jest.fn(),
        editTask: null,
        setShowForm: jest.fn(),
    };

    render(
        <TasksContext.Provider value={mockContext}>
            <TaskForm />
        </TasksContext.Provider>
    );

    const nameInput = screen.getByLabelText(/Task Name/i);
    const descriptionInput = screen.getByLabelText(/Task Description/i);

    fireEvent.change(nameInput, { target: { value: 'Test Task' } });
    fireEvent.change(descriptionInput, { target: { value: 'Test Description' } });

    expect(nameInput.value).toBe('Test Task');
    expect(descriptionInput.value).toBe('Test Description');
});

test('saves Task with form data on submit', () => {
    const mockSaveTask = jest.fn();
    const mockContext = {
        saveTask: mockSaveTask,
        editTask: null,
        setShowForm: jest.fn(),
    };

    render(
        <TasksContext.Provider value={mockContext}>
            <TaskForm />
        </TasksContext.Provider>
    );

    fireEvent.change(screen.getByLabelText(/Task Name/i), { target: { value: 'New Task' } });
    fireEvent.change(screen.getByLabelText(/Task Description/i), { target: { value: 'This is a new task' } });

    fireEvent.click(screen.getByRole('button', { name: /Add Task/i }));

    expect(mockSaveTask).toHaveBeenCalledWith({
        name: 'New Task',
        description: 'This is a new task',
    });
});
