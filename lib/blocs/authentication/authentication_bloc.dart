import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'authentication_event.dart';
import 'authentication_state.dart';
import '/repositories/authentication_repository.dart';

class AuthenticationBloc extends Bloc<AuthenticationEvent, AuthenticationState> {
  final AuthenticationRepository authenticationRepository;

  AuthenticationBloc({required this.authenticationRepository}) : super(AuthenticationInitial()) {
    on<AuthenticationLoginRequested>(_onLoginRequested);
  }

  Future<void> _onLoginRequested(
      AuthenticationLoginRequested event,
      Emitter<AuthenticationState> emit,
      ) async {
    emit(AuthenticationLoading());
    try {
      final token = await authenticationRepository.authenticate(
        email: event.email,
        password: event.password,
      );

      if (token != null) {
        final prefs = await SharedPreferences.getInstance();
        await prefs.setString('token', token);
        authenticationRepository.getInfo();
        emit(AuthenticationSuccess());
      } else {
        emit(AuthenticationFailure(error: 'Failed to obtain token'));
      }
    } catch (e) {
      print(e);
      emit(AuthenticationFailure(error: e.toString()));
    }
  }
}
