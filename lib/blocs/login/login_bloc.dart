import 'dart:convert';

import 'package:bloc/bloc.dart';
import 'package:formz/formz.dart';

import '../../repositories/authentication_repository.dart';
import '../../screens/login/component/password.dart';
import '../../screens/login/component/username.dart';
import 'login_event.dart';
import 'login_state.dart';

class LoginBloc extends Bloc<LoginEvent, LoginState> {
  LoginBloc({
    required AuthenticationRepository authenticationRepository,
  })  : _authenticationRepository = authenticationRepository,
        super(const LoginState()) {
    on<LoginUsernameChanged>(_onUsernameChanged);
    on<LoginPasswordChanged>(_onPasswordChanged);
    on<LoginSubmitted>(_onSubmitted);
    on<UpdateUser>(_onUpdateUser);
    on<ForgotPassword>(_onForgotPassword);
    on<ForgotClientID>(_onForgotClientID);
  }

  final AuthenticationRepository _authenticationRepository;

  void _onUsernameChanged(
    LoginUsernameChanged event,
    Emitter<LoginState> emit,
  ) {
    final username = Username.dirty(event.username);
    emit(
      state.copyWith(
        clientID: username,
        isValid: Formz.validate([state.password, username]),
        status: FormzSubmissionStatus.initial,
      ),
    );
  }

  void _onPasswordChanged(
    LoginPasswordChanged event,
    Emitter<LoginState> emit,
  ) {
    final password = Password.dirty(event.password);
    emit(
      state.copyWith(
        password: password,
        isValid: Formz.validate([password, state.clientID]),
        status: FormzSubmissionStatus.initial,
      ),
    );
  }

  Future<void> _onSubmitted(
    LoginSubmitted event,
    Emitter<LoginState> emit,
  ) async {
    if (state.isValid) {
      emit(state.copyWith(status: FormzSubmissionStatus.inProgress));
      try {
        await _authenticationRepository.logIn(
          clientID: state.clientID.value,
          password: state.password.value,
        );
        emit(state.copyWith(status: FormzSubmissionStatus.success));
      } catch (_) {
        emit(state.copyWith(status: FormzSubmissionStatus.failure));
      }
    }
  }

  Future<void> _onUpdateUser(
    UpdateUser event,
    Emitter<LoginState> emit,
  ) async {
    emit(state.copyWith(status: FormzSubmissionStatus.inProgress));
    try {
      AuthenticationRepository authenticationRepository =
          AuthenticationRepository();
      var dataRaw = await authenticationRepository.updateUserOnFirst(
        email: event.email,
        password: event.password,
      );
      var data = json.decode(dataRaw);
      if(data['error'] == null){
        emit(state.copyWith(status: FormzSubmissionStatus.success));
      } else{
        String error = data['error'].values.first[0] ?? "";
        emit(state.copyWith(status: FormzSubmissionStatus.failure, message: error));
      }
    } catch (_) {
      emit(state.copyWith(status: FormzSubmissionStatus.failure));
    }
  }

  Future<void> _onForgotPassword(
    ForgotPassword event,
    Emitter<LoginState> emit,
  ) async {
    emit(state.copyWith(status: FormzSubmissionStatus.inProgress));
    try {
      AuthenticationRepository authenticationRepository =
          AuthenticationRepository();
      var data = await authenticationRepository.forgotPassword(
        email: event.email,
      );
      if (data['error'] != null) {
        String error = (data['error'])['client_email'][0];
        emit(state.copyWith(
            status: FormzSubmissionStatus.failure, message: error));
      } else if (data['message'] != null) {
        String message = (data['message']);
        emit(state.copyWith(
            status: FormzSubmissionStatus.failure, message: message));
      }
    } catch (e) {
      print("Errors: $e");
      emit(state.copyWith(status: FormzSubmissionStatus.failure));
    }
  }

  Future<void> _onForgotClientID(
    ForgotClientID event,
    Emitter<LoginState> emit,
  ) async {
    emit(state.copyWith(status: FormzSubmissionStatus.inProgress));
    try {
      AuthenticationRepository authenticationRepository =
          AuthenticationRepository();
      var data = await authenticationRepository.forgotClientID(
        email: event.email,
      );
      if (data['error'] != null) {
        String error = (data['error'])['client_email'][0];
        emit(state.copyWith(
            status: FormzSubmissionStatus.failure, message: error));
      } else if (data['message'] != null) {
        String message = (data['message']);
        emit(state.copyWith(
            status: FormzSubmissionStatus.success, message: message));
      }
    } catch (e) {
      print("Errors: $e");
      emit(state.copyWith(status: FormzSubmissionStatus.failure));
    }
  }
}
